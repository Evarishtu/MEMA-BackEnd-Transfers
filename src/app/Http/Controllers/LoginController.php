<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{
    public function showLogin()
    {
        return view('auth.login');
    }
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $rol = $request->rol;

        $guard = match($rol){
            'admin' => 'admin',
            'hotel' => 'hotel',
            'viajero' => 'viajero',
            default => null,
        };
        if(!$guard){
            return back()->with('error', true);
        }
        if(Auth::guard($guard)->attempt($credentials)){
            return redirect()->route($rol . '.dashboard');
        }
        return back()->with('error', true);
    }
}
?>