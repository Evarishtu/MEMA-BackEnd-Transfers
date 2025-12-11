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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'rol' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        $guard = match($request->rol){
            'admin' => 'admin',
            'hotel' => 'hotel',
            'viajero' => 'viajero',
            default => null,
        };

        if(!$guard){
            return back()->with('error', true);
        }
        
        if(Auth::guard($guard)->attempt($credentials)){
            return redirect()->route($request->rol . '.dashboard');
        }
        return back()->with('error', true);
    }

    public function logout(Request $request){
        foreach(['admin', 'hotel', 'viajero'] as $guard){
            if(Auth::guard($guard)->check()){
                Auth::guard($guard)->logout();
            }
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
?>