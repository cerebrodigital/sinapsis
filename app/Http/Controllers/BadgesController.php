<?php namespace App\Http\Controllers;


use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class BadgesController extends Controller {

  /*
  |--------------------------------------------------------------------------
  | Home Controller
  |--------------------------------------------------------------------------
  |
  | This controller renders your application's "dashboard" for users that
  | are authenticated. Of course, you are free to change or remove the
  | controller as you wish. It is just here to get your app started!
  |
  */

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //$this->middleware('auth');


    //parent::__construct();

    //$this->news = $news;
    //$this->user = $user;
  }


  /**
   * Show the application dashboard to the user.
   *
   * @return Response
   */
  public function index()
  {
    return view('backend.badges.pages.home');
  }
  
  public function manage()
  {
    return view('backend.badges.pages.manage');
  }
  
  public function simulate()
  {
    return view('backend.badges.pages.simulate');
  }
  
  public function display()
  {
    return view('backend.badges.pages.display');
  }
  public function home()
  {
    return view('backend.pages.home');
  }
  public function profile()
  {
    return view('backend.pages.myprofile');
  }
}