<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();
        return response()->json($empresas);
    }

    public function show($id)
    {
        $empresa = Empresa::findOrFail($id);
        return response()->json($empresa);
    }

    public function store(Request $request)
    {
        $empresa = new Empresa();
        $empresa->name = $request->name;
        $empresa->cif = $request->cif;
        $empresa->phone = $request->phone;
        $empresa->email = $request->email;
        $empresa->address = [
            'region' => $request->address['region'],
            'town' => $request->address['town'],
            'street' => $request->address['street'],
            'position' => $request->address['position']
        ];
        $empresa->workingHours = [
            'start' => $request->workingHours['start'],
            'end' => $request->workingHours['end']
        ];
        $empresa->image = $request->image ?? 'https://picsum.photos/300/180';
        $empresa->categories = $request->categories;
        $empresa->services = $request->services;
        $empresa->openings = $request->openings;
        $empresa->score = [
            'teacher' => 0,
            'student' => 0
        ];
        $empresa->historicVacancies = [];
        $empresa->save();

        return response()->json($empresa, 201);
    }

    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);
        
        if (isset($request->name)) $empresa->name = $request->name;
        if (isset($request->phone)) $empresa->phone = $request->phone;
        if (isset($request->email)) $empresa->email = $request->email;
        if (isset($request->address)) {
            $empresa->address = [
                'region' => $request->address['region'],
                'town' => $request->address['town'],
                'street' => $request->address['street'],
                'position' => $request->address['position']
            ];
        }
        if (isset($request->workingHours)) {
            $empresa->workingHours = [
                'start' => $request->workingHours['start'],
                'end' => $request->workingHours['end']
            ];
        }
        if (isset($request->categories)) $empresa->categories = $request->categories;
        if (isset($request->services)) $empresa->services = $request->services;
        
        $empresa->save();

        return response()->json($empresa);
    }

    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();
        return response()->json(null, 204);
    }
} 