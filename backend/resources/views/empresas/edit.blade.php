@extends('partials.plantilla')

@section('titulo', 'Editar Empresa')
@section('contenido')
    <div class="container">
        <h1>Editar Empresa</h1>
        <form action="{{ route('empresas.update', $empresa) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $empresa->nombre }}" required>
            </div>
            <div class="mb-3">
                <label for="cif" class="form-label">CIF</label>
                <input type="text" class="form-control" id="cif" name="cif" value="{{ $empresa->cif }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $empresa->email }}" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $empresa->telefono }}" required>
            </div>
            <!-- Campos de dirección -->
            <div class="mb-3">
                <label for="address[region]" class="form-label">Provincia</label>
                <input type="text" class="form-control" id="address[region]" name="address[region]" value="{{ $empresa->direccion_provincia }}" required>
            </div>
            <div class="mb-3">
                <label for="address[town]" class="form-label">Población</label>
                <input type="text" class="form-control" id="address[town]" name="address[town]" value="{{ $empresa->poblacion }}" required>
            </div>
            <div class="mb-3">
                <label for="address[street]" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="address[street]" name="address[street]" value="{{ $empresa->direccion_calle }}" required>
            </div>
            <div class="mb-3">
                <label for="address[position][lat]" class="form-label">Latitud</label>
                <input type="number" step="any" class="form-control" id="address[position][lat]" name="address[position][lat]" value="{{ $empresa->direccion_lat }}" required>
            </div>
            <div class="mb-3">
                <label for="address[position][lng]" class="form-label">Longitud</label>
                <input type="number" step="any" class="form-control" id="address[position][lng]" name="address[position][lng]" value="{{ $empresa->direccion_lng }}" required>
            </div>
            <!-- Horario -->
            <div class="mb-3">
                <label for="workingHours[start]" class="form-label">Hora de inicio</label>
                <input type="time" class="form-control" id="workingHours[start]" name="workingHours[start]" value="{{ $empresa->horario_inicio }}" required>
            </div>
            <div class="mb-3">
                <label for="workingHours[end]" class="form-label">Hora de fin</label>
                <input type="time" class="form-control" id="workingHours[end]" name="workingHours[end]" value="{{ $empresa->horario_fin }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Empresa</button>
        </form>
    </div>
@endsection 