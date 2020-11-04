<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Activity;
use App\Model\Food;
use App\Model\Meal;
use App\MOdel\User;
use Barryvdh\DomPDF\Facade as PDF;

use Illuminate\Http\Request;

class ExportController extends Controller
{

    const FOLDER = "admin.day";

    public function index($id)
    {
        $user = User::find($id);
        $meals = Meal::all();
        $activity = Activity::all();
        $foods = Food::all();
        $title = "Export";
        $user_name = $user->name;

        return view(self::FOLDER . ".export", compact('user', 'title', 'user_name','meals', 'activity', 'foods'));
    }

    public function download($id)
    {
        $user = User::find($id);
        $meals = Meal::all();
        $activity = Activity::all();
        $foods = Food::all();
        $title = "Export";
        $user_name = $user->name;

        $pdf = PDF::loadView(self::FOLDER . ".export", compact('user', 'title', 'user_name','meals', 'activity', 'foods'));

        return $pdf->download('export.pdf');
    }
}
