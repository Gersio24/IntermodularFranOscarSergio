@extends('partials.plantilla')

@section('titulo', 'usuarios')
@section('contenido')
    <h1 class="text-center">Listado de Usuarios</h1>
    <div class="container">
        <h1>Lista de Usuarios</h1>

        <!-- Filtro por roles -->
        <form method="GET" class="mb-3">
            <label for="rol" class="form-label">Filtrar por rol:</label>
            <select name="rol" id="rol" class="form-select">
                <option value="">Seleccionar rol</option>
                <option value="Centro">Centro</option>
                <option value="Empresa">Empresa</option>
                <option value="Tutor">Tutor</option>
            </select>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>

        <!-- Añadir Usuario -->
        <div class="mb-3">
            <a href="{{ route('usuarios.create') }}" class="btn btn-success">Añadir Usuario</a>
        </div>

        <!-- Tabla de usuarios -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><a href="{{ route('usuarios', ['sort' => 'nombre', 'order' => $order]) }}">Nombre</a></th>
                    <th>NIF</th>
                    <th>Email</th>
                    <th><a href="{{ route('usuarios', ['sort' => 'id_centro', 'order' => $order]) }}">Centro</a></th>
                    <th><a href="{{ route('usuarios', ['sort' => 'id_empresa', 'order' => $order]) }}">Empresa</a></th>
                    <th>Roles</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    @if (!$usuario->roles->contains('nombre', 'Administrador'))
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
                            <td>
                                <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $usuarios->links() }}
        </div>
    </div>
@endsection
