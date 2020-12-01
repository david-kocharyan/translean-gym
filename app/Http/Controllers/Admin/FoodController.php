<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    const FOLDER = "admin.food";
    const TITLE = "Food Items";
    const ROUTE = "/foods";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Food::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . ".index", compact("title", "route", "data"));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Create";
        return view(self::FOLDER . ".create", compact("title", "route", 'action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "quantity_measure" => "required",
            "carbs" => "required|numeric",
            "fat" => "required|numeric",
            "proteins" => "required|numeric",
            "calories" => "required|numeric",
            "fiber" => "required|numeric",
            "glycemic_index" => "nullable|numeric",
            "glycemic_load" => "required|numeric",
            "ph" => "required|numeric",
        ]);

        $food = new Food;
        $food->name = $request->name;
        $food->quantity_measure = $request->quantity_measure;
        $food->carbs = $request->carbs;
        $food->fat = $request->fat;
        $food->proteins = $request->proteins;
        $food->calories = $request->calories;
        $food->fiber = $request->fiber;
        $food->glycemic_index = $request->glycemic_index ?? 0;
        $food->glycemic_load = $request->glycemic_load;
        $food->ph = $request->ph;
        $food->save();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Model\Food $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Model\Food $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . ".edit", compact("title", "route", 'action', "food"));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Food          $food
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Food $food)
    {
        $request->validate([
            "name" => "required",
            "quantity_measure" => "required",
            "carbs" => "required|numeric",
            "fat" => "required|numeric",
            "proteins" => "required|numeric",
            "calories" => "required|numeric",
            "fiber" => "required|numeric",
            "glycemic_index" => "nullable|numeric",
            "glycemic_load" => "required|numeric",
            "ph" => "required|numeric",
        ]);

        $food->name = $request->name;
        $food->quantity_measure = $request->quantity_measure;
        $food->carbs = $request->carbs;
        $food->fat = $request->fat;
        $food->proteins = $request->proteins;
        $food->calories = $request->calories;
        $food->fiber = $request->fiber;
        $food->glycemic_index = $request->glycemic_index ?? 0;
        $food->glycemic_load = $request->glycemic_load;
        $food->ph = $request->ph;
        $food->save();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Model\Food $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        Food::destroy($food->id);
        return redirect(self::ROUTE);
    }
}
