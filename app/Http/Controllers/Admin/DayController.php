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
use Illuminate\Database\QueryException;
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
        $user_name = $user->name;

        return view(self::FOLDER . ".index", compact('user', 'title', 'user_name', 'activity', 'meals', 'foods'));
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
        $meals = DayMeal::with(['getMeals', 'getPersonalFood'])->where(["user_id" => $user_id, "date" => $date])->get();
        $water = DayWater::where(["user_id" => $user_id, "date" => $date])->get();

        for ($i = 0; $i < count($activity); $i++) {
            $activity[$i]->from = Carbon::parse($activity[$i]->from)->format('H:i');
            $activity[$i]->to = Carbon::parse($activity[$i]->to)->format('H:i');
        }

        $body_weight = $this->getUserBodyWeight($user_id);

//        check assessment
        $assessment_status = false;
        $assessment_data = UserAssessments::where(["user_id" => $user_id])->first();
        if ($assessment_data != null) {
            $assessment_status = true;
        }
//        end check assessment

//        response all data
        $data = array(
            'activity' => $activity,
            'meal' => $meals,
            'water' => $water,
            'body_weight' => $body_weight,
            'assessment_status' => $assessment_status,
        );

        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     */
    public function calculateProteinMustEat(Request $request)
    {
        $user_id = $request->id;
        $date = $request->date;
        $total_met = $request->total_met;

       /* $activity = DayActivity::with('getActivity')->where(["user_id" => $user_id, "date" => $date])->get();
        for ($i = 0; $i < count($activity); $i++) {
            $activity[$i]->from = Carbon::parse($activity[$i]->from)->format('H:i');
            $activity[$i]->to = Carbon::parse($activity[$i]->to)->format('H:i');
        } */

        $total_prot_met = (float)$total_met;
         //print_r($total_prot_met); echo "<br>";
        /*foreach ($activity as $key => $val) {
            $from = Carbon::createFromFormat('H:i', $val->from);
            $to = Carbon::createFromFormat('H:i', $val->to);
            $diff_in_minutes = $to->diffInMinutes($from);
            $total_prot_met += ($diff_in_minutes * $val->getActivity->met);
        } */
       
        $met_variable = MetRange::where('lower_limit', '<=', $total_prot_met)
            ->where('upper_limit', '>=', $total_prot_met)->first();
        $assessment = UserAssessments::where(["user_id" => $user_id, "type" => 2])->first();
        $protein_must_eat = 0;
        if ($assessment != null and $met_variable != null) {
            $protein_must_eat = $met_variable->met_variable * $assessment->weight;
        }

        return response()->json(['protein_must_eat' => $protein_must_eat], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addActivity(Request $request)
    {
        $from = Carbon::parse($request->from)->format('H:i:s');
        $to = Carbon::parse($request->to)->format('H:i:s');

        $check_from = DayActivity::whereTime('from', '<', $from)
            ->whereTime('to', '>', $from)
            ->where('user_id', '=', $request->id)
            ->where('date', '=', $request->date)
            ->get();

        $check_to = DayActivity::whereTime('to', '>', $to)
            ->whereTime('from', '<', $to)
            ->where('user_id', '=', $request->id)
            ->where('date', '=', $request->date)
            ->get();

        if (!$check_from->isEmpty() OR !$check_to->isEmpty()) {
            return response()->json(['success' => "This Hour Is Already Taken!"], 422);
        }

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
        $activity[0]['from'] = Carbon::parse($activity[0]->from)->format('H:i');
        $activity[0]['to'] = Carbon::parse($activity[0]->to)->format('H:i');

        return response()->json(['success' => "Your activity has been saved.", 'activity' => $activity], 200);
    }

    /**
     * @param Request $request
     */
    public function editActivity(Request $request)
    {
        $current_activity = DayActivity::find($request->id);

        $from = Carbon::parse($request->from)->format('H:i:s');
        $to = Carbon::parse($request->to)->format('H:i:s');

        $check_from = DayActivity::whereTime('from', '<', $from)
            ->whereTime('to', '>', $from)
            ->where('user_id', '=', $request->user_id)
            ->where('date', '=', $request->date)
            ->where('id', '!=', $request->id)
            ->get();

        $check_to = DayActivity::whereTime('to', '>', $to)
            ->whereTime('from', '<', $to)
            ->where('user_id', '=', $request->user_id)
            ->where('date', '=', $request->date)
            ->where('id', '!=', $request->id)
            ->get();

        if (!$check_from->isEmpty() OR !$check_to->isEmpty()) {
            return response()->json(['success' => "This Hour Is Already Taken!"], 422);
        }

        $current_activity->activity_id = $request->activity;
        $current_activity->from = $from;
        $current_activity->to = $to;
        $current_activity->save();

        return response()->json(['success' => "Activity Has Been Updated Successfully!"], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteActivity(Request $request)
    {
        $res = DayActivity::where('id', $request->activity_id)->first()->delete();
        if ($res) {
            return response()->json(['success' => "Your activity has been deleted."], 200);
        } else {
            return response()->json(['success' => "Fail."], 422);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearAllActivity(Request $request)
    {
        if ($request->user_id == null OR $request->date == null) {
            return response()->json(array('msg' => 'Please Send User ID or Date!'), 422);
        }
        DayActivity::where(array('user_id' => $request->user_id, 'date' => $request->date))->delete();
        return response()->json(array('msg' => 'Activity Clear Successfully!'), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function duplicateActivity(Request $request)
    {
        if ($request->user_id == null OR $request->date_from == null OR $request->date_to == null) {
            return response()->json(array('msg' => 'Please Send User ID or Date From or Date To!'), 422);
        } elseif (!is_array($request->date_to)) {
            return response()->json(array('msg' => 'Date To must be array!'), 422);
        }

        $activity = DayActivity::where(array('user_id' => $request->user_id, 'date' => $request->date_from))->get();

        $arr_activity = array();
        foreach ($request->date_to as $k => $v) {
            foreach ($activity as $key => $val) {
                $arr_activity[] = [
                    'user_id' => $val->user_id,
                    'activity_id' => $val->activity_id,
                    'date' => $v,
                    'from' => $val->from,
                    'to' => $val->to,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            }
        }

        DB::beginTransaction();

        DayActivity::where('user_id', $request->user_id)->whereIn('date', $request->date_to)->delete();
        DayActivity::insert($arr_activity);

        DB::commit();

        return response()->json(array('msg' => 'Activity Duplicate Successfully!'), 200);
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
        $check_from_water = DayWater::where(array('user_id' => $data['id'], 'date' => $data['date'], 'from' => $data['from']))->first();

        if ($check_from != null OR $check_from_water != null) {
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
            "from" => "required",
        ]);

        $check_from = DayMeal::where(array('user_id' => $data['id'], 'date' => $data['date'], 'from' => $data['from']))->first();
        $check_from_water = DayWater::where(array('user_id' => $data['id'], 'date' => $data['date'], 'from' => $data['from']))->first();

        if ($check_from != null OR $check_from_water != null) {
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
    public function editMeal(Request $request)
    {
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
        $check_from = DayMeal::where(array('user_id' => $request->id, 'date' => $request->date, 'from' => $request->from))->where('id', "!=", $request->day_meal_id)->first();
        $check_from_water = DayWater::where(array('user_id' => $request->id, 'date' => $request->date, 'from' => $request->from))->first();

        if ($check_from != null OR $check_from_water != null) {
            return response()->json(array('msg' => 'This Time Is Busy!'), 422);
        }

        DB::beginTransaction();

        DayMeal::destroy('id', $request->day_meal_id);
        PersonalMeal::destroy('id', $request->personal_meal_id);

        $personal_meal = new PersonalMeal;
        $personal_meal->name = $meal_name;
        $personal_meal->mass = $request->total_mass;
        $personal_meal->carbs = $request->total_carbs;
        $personal_meal->fat = $request->total_fat;
        $personal_meal->proteins = $request->total_proteins;
        $personal_meal->calories = $request->total_calories;
        $personal_meal->ph = $request->total_ph;
        $personal_meal->glycemic_load = $request->total_glycemic_load;
        $personal_meal->save();

        $arr = array();
        foreach ($request->food as $bin => $key) {
            $arr[$bin]['personal_meal_id'] = $personal_meal->id;
            $arr[$bin]['food_id'] = $key;
            $arr[$bin]['mass'] = $request->mass[$bin];
        }

        $personal_meal->attachedFoods()->createMany($arr);

        $dayMeal = new DayMeal;
        $dayMeal->user_id = $request->id;
        $dayMeal->personal_meal_id = $personal_meal->id;
        $dayMeal->date = $request->date;
        $dayMeal->from = $request->from;
        $dayMeal->save();
        DB::commit();

        $meal = DayMeal::with('getMeals')->where(["id" => $dayMeal->id])->get();

        return response()->json(['success' => "Your meal has been saved.", 'meal' => $meal], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMeal(Request $request)
    {
        DayMeal::destroy('id', $request->id);
        PersonalMeal::destroy('id', $request->personal_meal_id);
        return response()->json(array('msg' => 'Meal deleted successfully!'), 200);
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
        $check_from_meal = DayMeal::where(array('user_id' => $request->user_id, 'date' => $request->date, 'from' => $request->from))->first();
        if ($check_from != null OR $check_from_meal != null) {
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editWater(Request $request)
    {
        $request->validate([
            "user_id" => "required",
            "date" => "required",
            "from" => "required",
            "quantity" => "required",
            "id" => "required"
        ]);

        $check_from = DayWater::where(array('user_id' => $request->user_id, 'date' => $request->date, 'from' => $request->from))->where('id', '!=', $request->id)->first();
        $check_from_meal = DayMeal::where(array('user_id' => $request->user_id, 'date' => $request->date, 'from' => $request->from))->first();

        if ($check_from != null OR $check_from_meal != null) {
            return response()->json(array('msg' => 'This Time Is Busy!'), 422);
        }

        $water = DayWater::find($request->id);
        $water->user_id = $request->user_id;
        $water->quantity = $request->quantity;
        $water->date = $request->date;
        $water->from = $request->from;
        $water->save();

        return response()->json(array('msg' => 'Water Edit Successfully!', 'water' => $water), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteWater(Request $request)
    {
        DayWater::destroy('id', $request->id);
        return response()->json(array('msg' => 'Water deleted successfully!'), 200);
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
        $user_name = $user->name;
        $assessments = UserAssessments::where('user_id', $user->id)->get();
        $projectionWeight = 0;
        $projection = UserAssessments::where(array('user_id' => $id, 'type' => 2))->first();
        if($projection) {
            $projectionWeight = $projection->weight;
        }
        
        return view(self::FOLDER . ".test", compact('user', 'title', 'user_name', 'activity', 'meals', 'foods',"assessments","projectionWeight"));
    }


}
