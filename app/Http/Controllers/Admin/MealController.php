<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Food;
use App\Model\Meal;
use App\Model\MealsFood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealController extends Controller
{

    const FOLDER = "admin.meal";
    const TITLE = "Meal";
    const ROUTE = "/meals";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Meal::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . ".index", compact("title", "route", "data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $foods = Food::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Create";
        return view(self::FOLDER . ".create", compact("title", "route", "action", 'foods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            "total_fiber" => "required|numeric",
        ]);

        DB::beginTransaction();

        $meal = new Meal;
        $meal->name = $request->name;
        $meal->mass = $request->total_mass;
        $meal->carbs = $request->total_carbs;
        $meal->fat = $request->total_fat;
        $meal->proteins = $request->total_proteins;
        $meal->calories = $request->total_calories;
        $meal->ph = $request->total_ph;
        $meal->glycemic_load = $request->total_glycemic_load;
        $meal->fiber = $request->total_fiber;
        $meal->save();

        $arr = array();
        foreach ($request->food as $bin => $key) {
            $arr[$bin]['meal_id'] = $meal->id;
            $arr[$bin]['food_id'] = $key;
            $arr[$bin]['mass'] = $request->mass[$bin];
        }

        $meal->attachedFoods()->createMany($arr);

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function edit(Meal $meal)
    {
        $foods = Food::all();
        $meal = Meal::with('attachedFoods','foods')->where('id', $meal->id)->first();
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . ".edit", compact("title", "route", "action", 'foods', 'meal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meal $meal)
    {
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
            "total_fiber" => "required|numeric",
        ]);

        DB::beginTransaction();

        $meal->name = $request->name;
        $meal->mass = $request->total_mass;
        $meal->carbs = $request->total_carbs;
        $meal->fat = $request->total_fat;
        $meal->proteins = $request->total_proteins;
        $meal->calories = $request->total_calories;
        $meal->ph = $request->total_ph;
        $meal->glycemic_load = $request->total_glycemic_load;
        $meal->fiber = $request->total_fiber;
        $meal->save();

        MealsFood::where('meal_id', $meal->id)->delete();

        $arr = array();
        foreach ($request->food as $bin => $key) {
            $arr[$bin]['meal_id'] = $meal->id;
            $arr[$bin]['food_id'] = $key;
            $arr[$bin]['mass'] = $request->mass[$bin];
        }

        $meal->attachedFoods()->createMany($arr);

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        Meal::destroy($meal->id);
        return redirect(self::ROUTE);
    }
}
