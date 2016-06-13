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
        if(\Auth::check()) {
            $user = \App\User::where('id', '=', \Auth::user()->id)->with('user_profile', 'posts', 'videos', 'topics', 'replies')->first();
            //dd($user);
            return \View::make('dashboard.home', compact('user'));
        } else {
            return \Redirect::to('/login');
        }
        
    }

    public function llenarPerfil()
    {
        if(\Auth::check()) {
            return \View::make('dashboard.profile_start');
        } else {
            return \Redirect::to('/login');
        }
        //return "por que sale 404";
        
    }
    


    // Perfil de autor
    public function authorProfile($id)
    {
        $user = \App\User::with('user_profile', 'posts', 'videos', 'topics', 'replies')->where('id', $id)->first();
        //dd($user);
        if($user) {
            return view('dashboard/profile', compact('user'));
        } else {
            abort(404);
        }
        
    }

    public function editProfileView()
    {
        if(\Auth::check()) {
            $user = \App\User::with('user_profile')->where('id', \Auth::user()->id)->first();
            return view('dashboard/profile_edit', compact('user'));
        } else {
            return \Redirect::route('sinapsis.login');
        }    
    }
    public function editProfile(Request $request)
    {
        //dd($request->all());
        $user_profile = new \App\models\UserProfile();
        $user_profile->user_id = $request->get('user_id');
        $user_profile->descripcion = $request->get('description');
        $user_profile->instagram = $request->get('instagram');
        $user_profile->facebook = $request->get('facebook');
        $user_profile->youtube = $request->get('youtube');
        $user_profile->googleplus = $request->get('googleplus');
        $user_profile->save();
        //dd($user_profile);
        return \Redirect::route('dashboard.perfil');

    }
}