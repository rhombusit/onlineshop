<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\DB;

class homeController extends Controller
{
     public function __construct() {
        $this->middleware('auth');
    }

   public function home()
   {

        return view('home');
   
   }
     public function components()
   {

        return view('components-table');
   
   }
    
  
}