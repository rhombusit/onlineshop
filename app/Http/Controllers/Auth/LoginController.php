<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
public function showLoginForm()
	{
		return view('auth.login');
	}
	public function logout()
    {
        Auth::logout(); // log the user out of our application
        return view('auth.login');
    }
    
    public function doLogin(Request $request) {
        
// validate the info, create rules for the inputs
$rules = array(
    'email'    => 'required', // make sure the email is an actual email
    'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
);

    $inputs = request()->all();

 // attempt to do the login
   if(Auth::attempt ( array (
'name' => $inputs['email'],
'password' => $inputs['password']
) )){
       // validation successful!
        // redirect them to the secure section or whatever
        // return Redirect::to('secure');
        // for now we'll just echo success (even though echoing in a controller is bad)
      return redirect()->route('home.show');
   } else{
           // validation not successful, send back to form 
        return view('auth.login');
      } 
    
    

}
}