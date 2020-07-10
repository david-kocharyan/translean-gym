<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MOdel\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    const FOLDER = "admin.users";
    const TITLE = "Users";
    const ROUTE = "/users";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
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
            "dob" => "required",
            "gender" => "required|numeric",
            "height" => "required|numeric",
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->height = $request->height;
        $user->save();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\MOdel\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\MOdel\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . ".edit", compact("title", "route", 'action', "user"));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\MOdel\User          $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            "name" => "required",
            "dob" => "required",
            "gender" => "required|numeric",
            "height" => "required|numeric",
        ]);

        $user->name = $request->name;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->height = $request->height;
        $user->save();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\MOdel\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect(self::ROUTE);
    }
}
