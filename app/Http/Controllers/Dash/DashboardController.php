 <?php

namespace App\Http\Controllers\Dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct() 
    {
      $this->middleware('auth');
    }

    public function home(Request $request)
    {
        return view('dashboard/home');
    }
}