<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Activity;
use App\Model\DayActivity;
use App\Model\DayMeal;
use App\Model\DayWater;
use App\Model\Food;
use App\Model\Meal;
use App\Model\MetRange;
use App\Model\PersonalMeal;
use App\Model\User;
use App\Model\UserAssessments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DayController extends Controller
{
    const FOLDER = "admin.day";
    const TITLE = "Day View";

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $user = User::find($id);
        $meals = Meal::all();
        $activity = Activity::all();
        $foods = Food::all();
        $title = self::TITLE;

        return view(self::FOLDER . ".index", compact('user', 'title', 'activity', 'meals', 'foods'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllData(Request $request)
    {
        $user_id = $request->id;
        $date = $request->date;

        $activity = DayActivity::with('getActivity')->where(["user_id" => $user_id, "date" => $date])->get();
        $meals = DayMeal::with('getMeals')->where(["user_id" => $user_id, "date" => $date])->get();
        $water = DayWater::where(["user_id" => $user_id, "date" => $date])->get();

        $total_prot_met = 0;
        foreach ($activity as $key => $val) {
            $from = Carbon::createFromFormat('H:i', $val->from);
            $to = Carbon::createFromFormat('H:i', $val->to);
            $diff_in_minutes = $to->diffInMinutes($from);
            $total_prot_met += ($diff_in_minutes * $val->getActivity->met);
        }

        $met_variable = MetRange::where('lower_limit', '<=', $total_prot_met)
            ->where('upper_limit', '>=', $total_prot_met)->first();

        $assessment = UserAssessments::where(["user_id" => $user_id, "type" => 1])->first();

        $protein_must_eat = 0;
        if ($assessment != null and $met_variable != null) {
            $protein_must_eat = $met_variable->met_variable * $assessment->lean_mass;
        }

        $body_weight = $this->getUserBodyWeight($user_id);

        $data = array(
            'activity' => $activity,
            'meal' => $meals,
            'water' => $water,
            'protein_must_eat' => $protein_must_eat,
            'body_weight' => $body_weight
        );

        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addActivity(Request $request)
    {
        $data = new DayActivity();
        $data->user_id = $request->id;
        $data->activity_id = $request->activity;
        $data->date = $request->date;
        $data->from = $request->from;
        $data->to = $request->to;
        $data->save();

        $activity = DayActivity::with('getActivity')->where(["id" => $data->id])->get();

        $body_weight = $this->getUserBodyWeight($request->id);
        $activity[0]['body_weight'] = $body_weight;

        return response()->json(['success' => "Your activity has been saved.", 'activity' => $activity], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addMeal(Request $request)
    {
        $data = $request->all();
        $request->validate([
            "meal" => "required",
            "food" => "required|array|min:1",
            "mass" => "required|array|min:1",
            "total_mass" => "required|numeric",
            "total_carbs" => "required|numeric",
            "total_fat" => "required|numeric",
            "total_proteins" => "required|numeric",
            "total_calories" => "required|numeric",
            "total_ph" => "required|numeric",
            "total_glycemic_load" => "required|numeric",
        ]);
        $meal_name = Meal::where('id', $request->meal)->first()->name;

        $check_from = DayMeal::where(array('user_id' => $data['id'], 'date' => $data['date'], 'from' => $data['from']))->first();
        if ($check_from != null) {
            return response()->json(array('msg' => 'This Time Is Busy!'), 422);
        }

        DB::beginTransaction();

        $personal_meal = new PersonalMeal;
        $personal_meal->name = $meal_name;
        $personal_meal->mass = $data['total_mass'];
        $personal_meal->carbs = $data['total_carbs'];
        $personal_meal->fat = $data['total_fat'];
        $personal_meal->proteins = $data['total_proteins'];
        $personal_meal->calories = $data['total_calories'];
        $personal_meal->ph = $data['total_ph'];
        $personal_meal->glycemic_load = $data['total_glycemic_load'];
        $personal_meal->save();

        $arr = array();
        foreach ($data['food'] as $bin => $key) {
            $arr[$bin]['personal_meal_id'] = $personal_meal->id;
            $arr[$bin]['food_id'] = $key;
            $arr[$bin]['mass'] = $data['mass'][$bin];
        }

        $personal_meal->attachedFoods()->createMany($arr);

        $dayMeal = new DayMeal;
        $dayMeal->user_id = $data['id'];
        $dayMeal->personal_meal_id = $personal_meal->id;
        $dayMeal->date = $data['date'];
        $dayMeal->from = $data['from'];
        $dayMeal->save();
        DB::commit();

        $meal = DayMeal::with('getMeals')->where(["id" => $dayMeal->id])->get();

        return response()->json(['success' => "Your meal has been saved.", 'meal' => $meal], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMeal(Request $request)
    {
        $data = $request->all();
        $request->validate([
            "name" => "required",
            "food" => "required|array|min:1",
            "mass" => "required|array|min:1",
            "total_mass" => "required|numeric",
            "total_carbs" => "required|numeric",
            "total_fat" => "required|numeric",
            "total_proteins" => "required|numeric",
            "total_calories" => "required|numeric",
            "total_ph" => "required|numeric",
            "total_glycemic_load" => "required|numeric",
        ]);

        $check_from = DayMeal::where(array('user_id' => $data['id'], 'date' => $data['date'], 'from' => $data['from']))->first();
        if ($check_from != null) {
            return response()->json(array('msg' => 'This Time Is Busy!'), 422);
        }

        DB::beginTransaction();
        $meal = new Meal;
        $meal->name = $data['name'];
        $meal->mass = $data['total_mass'];
        $meal->carbs = $data['total_carbs'];
        $meal->fat = $data['total_fat'];
        $meal->proteins = $data['total_proteins'];
        $meal->calories = $data['total_calories'];
        $meal->ph = $data['total_ph'];
        $meal->glycemic_load = $data['total_glycemic_load'];
        $meal->save();

        $personal_meal = new PersonalMeal;
        $personal_meal->name = $meal->name;
        $personal_meal->mass = $data['total_mass'];
        $personal_meal->carbs = $data['total_carbs'];
        $personal_meal->fat = $data['total_fat'];
        $personal_meal->proteins = $data['total_proteins'];
        $personal_meal->calories = $data['total_calories'];
        $personal_meal->ph = $data['total_ph'];
        $personal_meal->glycemic_load = $data['total_glycemic_load'];
        $personal_meal->save();

        $arr = array();
        $arrPerson = array();
        foreach ($data['food'] as $bin => $key) {
            $arrPerson[$bin]['personal_meal_id'] = $personal_meal->id;
            $arr[$bin]['meal_id'] = $meal->id;
            $arr[$bin]['food_id'] = $arrPerson[$bin]['food_id'] = $key;
            $arr[$bin]['mass'] = $arrPerson[$bin]['mass'] = $data['mass'][$bin];
        }
        $meal->attachedFoods()->createMany($arr);
        $personal_meal->attachedFoods()->createMany($arrPerson);

        $dayMeal = new DayMeal;
        $dayMeal->user_id = $data['id'];
        $dayMeal->personal_meal_id = $personal_meal->id;
        $dayMeal->date = $data['date'];
        $dayMeal->from = $data['from'];
        $dayMeal->save();

        DB::commit();

        return response()->json(array('msg' => 'Successfully Form Submit', 'status' => true, 'meal' => $meal));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMealAjax(Request $request)
    {
        $id = $request->id;
        $meal = Meal::with('attachedFoods', 'foods')->where('id', $id)->first();
        return response()->json($meal);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearMeal(Request $request)
    {
        if ($request->user_id == null OR $request->date == null) {
            return response()->json(array('msg' => 'Please Send User ID or Date!'), 422);
        }
        DayMeal::where(array('user_id' => $request->user_id, 'date' => $request->date))->delete();
        return response()->json(array('msg' => 'Meal Clear Successfully!'), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function duplicateMeal(Request $request)
    {
        if ($request->user_id == null OR $request->date_from == null OR $request->date_to == null) {
            return response()->json(array('msg' => 'Please Send User ID or Date From or Date To!'), 422);
        } elseif (!is_array($request->date_to)) {
            return response()->json(array('msg' => 'Date To must be array!'), 422);
        }

        $meal = DayMeal::where(array('user_id' => $request->user_id, 'date' => $request->date_from))->get();
        $water = DayWater::where(array('user_id' => $request->user_id, 'date' => $request->date_from))->get();

        $arr_meal = array();
        $arr_water = array();
        foreach ($request->date_to as $k => $v) {
            foreach ($meal as $key => $val) {
                $arr_meal[] = [
                    'user_id' => $val->user_id,
                    'personal_meal_id' => $val->personal_meal_id,
                    'date' => $v,
                    'from' => $val->from,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            }

            foreach ($water as $key => $val) {
                $arr_water[] = [
                    'user_id' => $val->user_id,
                    'quantity' => $val->quantity,
                    'date' => $v,
                    'from' => $val->from,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            }
        }

        DB::beginTransaction();

        DayMeal::where('user_id', $request->user_id)->whereIn('date', $request->date_to)->delete();
        DayMeal::insert($arr_meal);

        DayWater::where('user_id', $request->user_id)->whereIn('date', $request->date_to)->delete();
        DayWater::insert($arr_water);

        DB::commit();

        return response()->json(array('msg' => 'Meal Duplicate Successfully!'), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addWater(Request $request)
    {
        $request->validate([
            "user_id" => "required",
            "date" => "required",
            "from" => "required",
            "quantity" => "required",
        ]);

        $check_from = DayWater::where(array('user_id' => $request->user_id, 'date' => $request->date, 'from' => $request->from))->first();
        if ($check_from != null) {
            return response()->json(array('msg' => 'This Time Is Busy!'), 422);
        }

        $water = new DayWater;
        $water->user_id = $request->user_id;
        $water->quantity = $request->quantity;
        $water->date = $request->date;
        $water->from = $request->from;
        $water->save();

        return response()->json(array('msg' => 'Water Save Successfully!', 'water' => $water), 200);
    }

    /**
     * @param $id
     * @return int
     */
    private function getUserBodyWeight($id)
    {
        $body_weight = 0;
        $projection = UserAssessments::where(array('user_id' => $id, 'type' => UserAssessments::TYPE[2]))->first();
        if ($projection != null) {
            $body_weight = $projection->weight;
        } else {
            $assessment = UserAssessments::where(array('user_id' => $id, 'type' => UserAssessments::TYPE[1]))->first();
            if ($assessment != null) {
                $body_weight = $assessment->weight;
            }
        }
        return $body_weight;
    }

//    test part
    public function testIndex($id)
    {
        $user = User::find($id);
        $meals = Meal::all();
        $activity = Activity::all();
        $foods = Food::all();
        $title = self::TITLE;


        return view(self::FOLDER . ".test", compact('user', 'title', 'activity', 'meals', 'foods'));
    }


}
