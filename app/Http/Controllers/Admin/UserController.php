<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MOdel\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    const FOLDER = "admin.users";
    const TITLE = "Users";
    const ROUTE = "/users";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->search)) {
            $data = User::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('username', 'LIKE', '%' . $request->search . '%')
                ->paginate(10);
        } else {
            $data = User::paginate(10);
        }
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
            "phone" => "required",
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
        if ($request->wake_up_time != null){
            $user->wake_up_time = $request->wake_up_time;
        }else{
            $user->wake_up_time = "08:00";
        }

        if ($request->image) {
            $image_name = Storage::disk('public')->put('users/', $request->image);
            $user->image = $image_name;
        }

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
            "username" => "required|unique:users,username," . $user->id,
            "email" => "unique:users,email," . $user->id,
            "password" => "nullable|min:6",
            "dob" => "required",
            "gender" => "required|numeric",
            "height" => "required|numeric",
            "dimmer" => "required|numeric",
            "protein_hourly_limit" => "required|numeric",
            "phone" => "required",
        ]);

        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }
        if ($request->email != null) {
            $user->email = $request->email;
        }
        if ($request->image){
            Storage::disk('public')->delete("$user->image");
            $image_name =  Storage::disk('public')->put('users/', $request->image);
            $user->image = $image_name;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->height = $request->height;
        $user->dimmer = $request->dimmer;
        $user->protein_hourly_limit = $request->protein_hourly_limit;
        if ($request->wake_up_time != null){
            $user->wake_up_time = $request->wake_up_time;
        }else{
            $user->wake_up_time = "08:00";
        }
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

    public function search(Request $request)
    {


        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . ".index", compact("title", "route", "data"));
    }
}
