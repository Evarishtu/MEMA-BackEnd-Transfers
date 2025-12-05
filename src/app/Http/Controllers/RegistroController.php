<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Hotel;
use App\Models\Viajero;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller{
    public function index(){
        return view('auth.registro.index');
    }
    public function seleccionar(Request $request){
        $request->validate([
            'rol' => 'required|in:viajero,hotel,admin',
        ]);
        return match ($request->rol){
            'viajero' => redirect()->route('registro.viajero'),
            'hotel' => redirect()->route('registro.hotel'),
            'admin' => redirect()->route('registro.admin'),
        };
    }

    public function registroViajero(){
        return view('auth.registro.viajero');
    }
    public function storeViajero(Request $request){
        $request->validate([
            'email'        => 'required|email|unique:viajeros,email',
            'password'     => 'required|min=4',
            'nombre'       => 'required',
            'apellido1'    => 'required',
            'apellido2'    => 'required',
            'direccion'    => 'required',
            'codigoPostal' => 'required',
            'pais'         => 'required',
            'ciudad'       => 'required',
        ]);
        Viajero::create([
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'nombre'       => $request->nombre,
            'apellido1'    => $request->apellido1,
            'apellido2'    => $request->apellido2,
            'direccion'    => $request->direccion,
            'codigoPostal' => $request->codigoPostal,
            'pais'         => $request->pais,
            'ciudad'       => $request->ciudad,
        ]);
        return redirect()->route('login')->with('success', 'Viajero registrado correctamente');
    }
    public function registroHotel(){
        return view('auth.registro.hotel');
    }
    public function storeHotel(Request $request){
        $request->validate([
            'nombre'    => 'required',
            'usuario'   => 'required|unique:hoteles,usuario',
            'password'  => 'required|min=4',
            'id_zona'   => 'nullable|numeric',
            'comision'  => 'nullable|numeric|min=0|max=100',
        ]);
        Hotel::create([
            'nombre'   => $request->nombre,
            'usuario'  => $request->usuario,
            'password' => Hash::make($request->password),
            'id_zona'  => $request->id_zona,
            'comision' => $request->comision,
        ]);
        return redirect()->route('login')->with('success', 'Hotel registrado correctamente');
    }
    public function registroAdmin(){
        return view('auth.registro.admin');
    }
    public function storeAdmin(Request $request){
        $request->validate([
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|min=4',
        ]);
        Admin::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('login')->with('success', 'Administrador registrado correctamente');
    }
}


?>