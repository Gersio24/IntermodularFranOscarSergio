@extends('partials.plantilla')

@section('titulo', 'Centros')
@section('contenido')
    <h1 class="text-center">Listado de Centros</h1>
    <div class="container">
        <div class="mb-3">
            <a href="{{ route('centros.create') }}" class="btn btn-success">Añadir Centro</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Provincia</th>
                    <th>Población</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($centros as $centro)
                    <tr>
                        <td>{{ $centro->nombre }}</td>
                        <td>{{ $centro->email }}</td>
                        <td>{{ $centro->telefono }}</td>
                        <td>{{ $centro->provincia }}</td>
                        <td>{{ $centro->poblacion }}</td>
                        <td>
                            <a href="{{ route('centros.show', $centro) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('centros.edit', $centro) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('centros.destroy', $centro) }}" method="POST" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('¿Está seguro de eliminar este centro?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $centros->links() }}
        </div>
    </div>
@endsection 