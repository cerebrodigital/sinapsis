<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    //DASHBOARD ES EL PANEL DE PERFIL Y KPI DE CADA USUARIO

    //Home para ver tus KPI
    public function home()
    {

        return \View::make('dashboard.home');
    }
    


    // Perfil de autor
    public function authorProfile($id)
    {
        $user = \App\User::with('user_profile')->where('id', $id)->get();


        return view('dashboard/profile', compact('user'));
    }
}