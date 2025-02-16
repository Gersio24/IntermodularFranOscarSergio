@extends('partials.plantilla')

@section('titulo', 'Empresas')
@section('contenido')
    <h1 class="text-center">Listado de Empresas</h1>
    <div class="container">
        <div class="mb-3">
            <a href="{{ route('empresas.create') }}" class="btn btn-success">Añadir Empresa</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>CIF</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Provincia</th>
                    <th>Población</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($empresas as $empresa)
                    <tr>
                        <td>{{ $empresa->nombre }}</td>
                        <td>{{ $empresa->cif }}</td>
                        <td>{{ $empresa->email }}</td>
                        <td>{{ $empresa->telefono }}</td>
                        <td>{{ $empresa->direccion_provincia }}</td>
                        <td>{{ $empresa->poblacion }}</td>
                        <td>
                            <a href="{{ route('empresas.show', $empresa) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('empresas.edit', $empresa) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('empresas.destroy', $empresa) }}" method="POST" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $empresas->links() }}
        </div>
    </div>
@endsection 