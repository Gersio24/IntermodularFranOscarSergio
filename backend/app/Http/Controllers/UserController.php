<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Centro;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserController extends Controller
{
    public function index(Request $request)
{
    $query = User::query();

    if ($request->has('rol') && $request->rol != '') {
        $query->whereHas('roles', function ($query) use ($request) {
            $query->where('nombre', $request->rol);
        });
    }

    $query->whereDoesntHave('roles', function ($query) {
        $query->where('nombre', 'Administrador');
    });

    $sort = $request->get('sort', 'nombre');
    $order = $request->get('order', 'asc');
    $usuarios = $query->orderBy($sort, $order)->paginate(10);

    return view('usuarios', compact('usuarios', 'order', 'sort'));
}




    public function show($id)
    {
        return User::find($id);
    }

    public function create()
    {
        $centros = Centro::all();
        $empresas = Empresa::all();
        return view('formUsu', compact(['centros', 'empresas']));
    }


    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'NIF' => 'required|string|max:15|unique:Users,NIF',
        'email' => 'required|email|unique:Users,email',
        'password' => 'required|string|min:6',
        'centros' => 'required|exists:centros,id',
        'empresas' => 'required|exists:empresas,id',
        'roles' => 'required|array|min:1',
        'roles.*' => 'in:1,2,3',
    ], [
        'nombre.required' => 'El nombre es obligatorio.',
        'NIF.required' => 'El NIF es obligatorio.',
        'NIF.unique' => 'Este NIF ya está registrado.',
        'email.required' => 'El email es obligatorio.',
        'email.email' => 'El formato del email es inválido.',
        'email.unique' => 'Este email ya está registrado.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        'centros.required' => 'Debes seleccionar un centro.',
        'centros.exists' => 'El centro seleccionado no es válido.',
        'empresas.required' => 'Debes seleccionar una empresa.',
        'empresas.exists' => 'La empresa seleccionada no es válida.',
        'roles.required' => 'Debes seleccionar al menos un rol.',
        'roles.array' => 'El formato de los roles no es válido.',
        'roles.min' => 'Debes seleccionar al menos un rol.',
        'roles.*.in' => 'Rol seleccionado no válido.',
    ]);

    $User = new User();
    $User->nombre = $request->nombre;
    $User->NIF = $request->NIF;
    $User->email = $request->email;
    $User->password = bcrypt($request->password);
    $User->id_centro = $request->centros;
    $User->id_empresa = $request->empresas;
    $User->save();

    $User->roles()->attach($request->roles);

    return redirect()->route('usuarios')->with('success', 'User creado.');
}


    public function edit(User $usuario)
    {
        $centros = Centro::all();
        $empresas = Empresa::all();
        return view('formUsu', compact(['usuario', 'centros', 'empresas']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'NIF' => 'required|string|max:15',
            'email' => 'required|email',
            'centros' => 'required|exists:centros,id',
            'empresas' => 'required|exists:empresas,id',
            'roles' => 'required|array|min:1',
            'roles.*' => 'in:1,2,3',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'NIF.required' => 'El NIF es obligatorio.',
            'NIF.unique' => 'Este NIF ya está registrado.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El formato del email es inválido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'centros.required' => 'Debes seleccionar un centro.',
            'centros.exists' => 'El centro seleccionado no es válido.',
            'empresas.required' => 'Debes seleccionar una empresa.',
            'empresas.exists' => 'La empresa seleccionada no es válida.',
            'roles.required' => 'Debes seleccionar al menos un rol.',
            'roles.array' => 'El formato de los roles no es válido.',
            'roles.min' => 'Debes seleccionar al menos un rol.',
            'roles.*.in' => 'Rol seleccionado no válido.',
        ]);
        $User = User::findOrFail($id);
        $User->nombre = $request->nombre;
        $User->NIF = $request->NIF;
        $User->email = $request->email;
        if ($request->filled('password')) {
            $User->password = bcrypt($request->password);
        }
        $User->id_centro = $request->centros;
        $User->id_empresa = $request->empresas;
        $User->save();

        $User->roles()->sync($request->roles);


        return redirect()->route('usuarios')->with('success', 'User actualizado correctamente');
    }

    public function destroy($id)
    {
        $User = User::findOrFail($id);
        $User->delete();

        return redirect()->route('usuarios')->with('success', 'User eliminado correctamente');
    }

}
