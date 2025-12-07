<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferVehiculo;
use Illuminate\Support\Facades\Hash;

class VehiculoController extends Controller{
    public function index(){
        $vehiculos = TransferVehiculo::orderBy('id_vehiculo')->get();
        return view('vehiculo.index', compact('vehiculos'));
    }
    public function create(){
        return view('vehiculo.form');
    }
    public function store(Request $request){
        $request->validate([
            'descripcion' => 'required|max:225',
            'email_conductor' => 'nullable|email',
            'password' => 'required|min:4',
        ]);
        TransferVehiculo::create([
            'descripcion' => $request->descripcion,
            'email_conductor' => $request->email_conductor,
            'password' => $request->password ? Hash::make($request->password) : null,
        ]);
        return redirect()->route('vehiculo.index')->with('success', 'vehiculo creado correctamente');
    }
    public function edit($id){
        $vehiculo = TransferVehiculo::findOrFail($id);
        return view('vehiculo.form', compact('vehiculo'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'descripcion' => 'required|max:255',
        ]);
        $vehiculo = TransferVehiculo::findOrFail($id);
        $vehiculo->update([
            'descripcion' => $request->descripcion,
        ]);
        return redirect()->route('vehiculo.index')->with('success', 'Vehiculo actualizado correctamente');
    }
    public function destroy($id){
        TransferVehiculo::destroy($id);
        return redirect()->route('vehiculo.index')->with('success', 'Vehiculo eliminado correctamente');
    }
}
?>