<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use Illuminate\Http\Request;

class CentroController extends Controller
{
    public function index()
    {
        $centros = Centro::paginate(10);
        return view('centros.index', compact('centros'));
    }

    public function create()
    {
        return view('centros.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:centros',
            'password' => 'required|min:6',
            'direccion' => 'required',
            'telefono' => 'required',
            'poblacion' => 'required',
            'provincia' => 'required'
        ]);

        $centro = new Centro();
        $centro->nombre = $request->nombre;
        $centro->email = $request->email;
        $centro->password = bcrypt($request->password);
        $centro->direccion = $request->direccion;
        $centro->telefono = $request->telefono;
        $centro->poblacion = $request->poblacion;
        $centro->provincia = $request->provincia;
        $centro->save();

        return redirect()->route('centros.index')
            ->with('success', 'Centro creado correctamente');
    }

    public function show(Centro $centro)
    {
        return view('centros.show', ['centro' => $centro]);
    }

    public function edit(Centro $centro)
    {
        return view('centros.edit', ['centro' => $centro]);
    }

    public function update(Request $request, Centro $centro)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:centros,email,'.$centro->id,
            'direccion' => 'required',
            'telefono' => 'required',
            'poblacion' => 'required',
            'provincia' => 'required'
        ]);

        $centro->nombre = $request->nombre;
        $centro->email = $request->email;
        if ($request->filled('password')) {
            $centro->password = bcrypt($request->password);
        }
        $centro->direccion = $request->direccion;
        $centro->telefono = $request->telefono;
        $centro->poblacion = $request->poblacion;
        $centro->provincia = $request->provincia;
        $centro->save();

        return redirect()->route('centros.index')
            ->with('success', 'Centro actualizado correctamente');
    }

    public function destroy(Centro $centro)
    {
        $centro->delete();
        return redirect()->route('centros.index')
            ->with('success', 'Centro eliminado correctamente');
    }
}
