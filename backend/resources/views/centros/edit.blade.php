@extends('partials.plantilla')

@section('titulo', 'Editar Centro')

@section('contenido')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Editar Centro: {{ $centro->nombre }}</h1>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('centros.update', $centro) }}" method="POST" class="row g-3">
        @csrf
        @method('PUT')
        
        <!-- Información básica -->
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre del Centro</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $centro->nombre) }}" required>
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $centro->email) }}" required>
        </div>

        <div class="col-md-6">
            <label for="password" class="form-label">Contraseña (dejar en blanco para mantener la actual)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="col-md-6">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $centro->telefono) }}" required>
        </div>

        <!-- Dirección -->
        <div class="col-12">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $centro->direccion) }}" required>
        </div>

        <div class="col-md-6">
            <label for="poblacion" class="form-label">Población</label>
            <input type="text" class="form-control" id="poblacion" name="poblacion" value="{{ old('poblacion', $centro->poblacion) }}" required>
        </div>

        <div class="col-md-6">
            <label for="provincia" class="form-label">Provincia</label>
            <input type="text" class="form-control" id="provincia" name="provincia" value="{{ old('provincia', $centro->provincia) }}" required>
        </div>

        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-primary">Actualizar Centro</button>
            <a href="{{ route('centros.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
        </div>
    </form>
</div>
@endsection 