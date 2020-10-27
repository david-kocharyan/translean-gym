<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MOdel\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $data = User::paginate(10);
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
            "username" => "required|unique:users,username",
            "email" => "unique:users,email",
            "password" => "required|min:6",
            "dob" => "required",
            "gender" => "required|numeric",
            "height" => "required|numeric",
            "dimmer" => "required|numeric",
            "protein_hourly_limit" => "required|numeric",
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->height = $request->height;
        $user->dimmer = $request->dimmer;
        $user->protein_hourly_limit = $request->protein_hourly_limit;
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
        $title = "Basic";
        $route = self::ROUTE;
        $user_name = $user->name;

        return view(self::FOLDER . ".show", compact("title", "route", 'user', 'user_name'));
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
            "username" => "required|unique:users,username,". $user->id,
            "email" => "unique:users,email,". $user->id,
            "dob" => "required",
            "gender" => "required|numeric",
            "height" => "required|numeric",
            "dimmer" => "required|numeric",
            "protein_hourly_limit" => "required|numeric",
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->height = $request->height;
        $user->dimmer = $request->dimmer;
        $user->protein_hourly_limit = $request->protein_hourly_limit;
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
