@extends('partials.plantilla')

@section('titulo', 'usuarios')
@section('contenido')
    <h1 class="text-center">Listado de Usuarios</h1>
    <div class="container">
        <h1>Lista de Usuarios</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>NIF</th>
                    <th>Email</th>
                    <th>Centro</th>
                    <th>Empresa</th>
                    <th>Roles</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->NIF }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->centro->nombre ?? 'Sin asignar' }}</td>
                        <td>{{ $usuario->empresa->nombre ?? 'Sin asignar' }}</td>
                        <td>
                            @foreach ($usuario->roles as $rol)
                                <span class="badge bg-primary">{{ $rol->nombre }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $usuarios->links() }}
        </div>
    </div>

@endsection
