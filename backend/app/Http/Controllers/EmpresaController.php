<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::paginate(10);
        return view('empresas', ['empresas' => $empresas]);
    }

    public function create()
    {
        return view('empresas.create');
    }

    public function store(Request $request)
    {
        $empresa = new Empresa();
        $empresa->nombre = $request->name;
        $empresa->cif = $request->cif;
        $empresa->telefono = $request->phone;
        $empresa->email = $request->email;
        $empresa->direccion_provincia = $request->address['region'];
        $empresa->poblacion = $request->address['town'];
        $empresa->direccion_calle = $request->address['street'];
        $empresa->direccion_lat = $request->address['position']['lat'];
        $empresa->direccion_lng = $request->address['position']['lng'];
        $empresa->horario_inicio = $request->workingHours['start'];
        $empresa->horario_fin = $request->workingHours['end'];
        $empresa->imagen = $request->image ?? 'https://picsum.photos/300/180';
        $empresa->categorias = $request->categories;
        $empresa->servicios = $request->services;
        $empresa->vacantes_historico = [];
        $empresa->puntuacion_profesor = 0;
        $empresa->puntuacion_alumno = 0;
        $empresa->save();

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa creada exitosamente');
    }

    public function show(Empresa $empresa)
    {
        return view('empresas.show', ['empresa' => $empresa]);
    }

    public function edit(Empresa $empresa)
    {
        return view('empresas.edit', ['empresa' => $empresa]);
    }

    public function update(Request $request, Empresa $empresa)
    {
        if (isset($request->name)) $empresa->nombre = $request->name;
        if (isset($request->phone)) $empresa->telefono = $request->phone;
        if (isset($request->email)) $empresa->email = $request->email;
        if (isset($request->address)) {
            $empresa->direccion_provincia = $request->address['region'];
            $empresa->poblacion = $request->address['town'];
            $empresa->direccion_calle = $request->address['street'];
            $empresa->direccion_lat = $request->address['position']['lat'];
            $empresa->direccion_lng = $request->address['position']['lng'];
        }
        if (isset($request->workingHours)) {
            $empresa->horario_inicio = $request->workingHours['start'];
            $empresa->horario_fin = $request->workingHours['end'];
        }
        if (isset($request->categories)) $empresa->categorias = $request->categories;
        if (isset($request->services)) $empresa->servicios = $request->services;
        
        $empresa->save();

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa actualizada exitosamente');
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('empresas.index')
            ->with('success', 'Empresa eliminada exitosamente');
    }
}
