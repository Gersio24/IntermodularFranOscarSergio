@extends('partials.plantilla')

@section('titulo', 'Crear Empresa')
@section('contenido')
    <div class="container">
        <h1>Crear Nueva Empresa</h1>
        <form action="{{ route('empresas.store') }}" method="POST" class="row g-3">
            @csrf
            <!-- Información básica -->
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="col-md-6">
                <label for="cif" class="form-label">CIF</label>
                <input type="text" class="form-control" id="cif" name="cif" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-md-6">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>

            <!-- Dirección -->
            <div class="col-md-6">
                <label for="direccion_provincia" class="form-label">Provincia</label>
                <input type="text" class="form-control" id="direccion_provincia" name="direccion_provincia" required>
            </div>
            <div class="col-md-6">
                <label for="poblacion" class="form-label">Población</label>
                <input type="text" class="form-control" id="poblacion" name="poblacion" required>
            </div>
            <div class="col-12">
                <label for="direccion_calle" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion_calle" name="direccion_calle" required>
            </div>
            <div class="col-md-6">
                <label for="direccion_lat" class="form-label">Latitud</label>
                <input type="number" step="any" class="form-control" id="direccion_lat" name="direccion_lat" required>
            </div>
            <div class="col-md-6">
                <label for="direccion_lng" class="form-label">Longitud</label>
                <input type="number" step="any" class="form-control" id="direccion_lng" name="direccion_lng" required>
            </div>

            <!-- Horario -->
            <div class="col-md-6">
                <label for="horario_inicio" class="form-label">Hora de inicio</label>
                <input type="time" class="form-control" id="horario_inicio" name="horario_inicio" required>
            </div>
            <div class="col-md-6">
                <label for="horario_fin" class="form-label">Hora de fin</label>
                <input type="time" class="form-control" id="horario_fin" name="horario_fin" required>
            </div>

            <!-- Imagen -->
            <div class="col-12">
                <label for="imagen" class="form-label">URL de la imagen</label>
                <input type="url" class="form-control" id="imagen" name="imagen" placeholder="https://picsum.photos/300/180">
            </div>

            <!-- Categorías y Servicios -->
            <div class="col-md-6">
                <label for="categorias" class="form-label">Categorías</label>
                <select class="form-select" id="categorias" name="categorias[]" multiple required>
                    <option value="desarrollo">Desarrollo</option>
                    <option value="diseño">Diseño</option>
                    <option value="marketing">Marketing</option>
                    <option value="sistemas">Sistemas</option>
                </select>
                <div class="form-text">Mantén presionado Ctrl para seleccionar múltiples categorías</div>
            </div>
            <div class="col-md-6">
                <label for="servicios" class="form-label">Servicios</label>
                <select class="form-select" id="servicios" name="servicios[]" multiple required>
                    <option value="web">Desarrollo Web</option>
                    <option value="movil">Desarrollo Móvil</option>
                    <option value="ui">Diseño UI</option>
                    <option value="ux">Diseño UX</option>
                </select>
                <div class="form-text">Mantén presionado Ctrl para seleccionar múltiples servicios</div>
            </div>

            <!-- Vacantes -->
            <div class="col-md-6">
                <label for="vacantes_año" class="form-label">Año de vacantes</label>
                <input type="number" class="form-control" id="vacantes_año" name="vacantes_historico[0][year]" value="{{ date('Y') }}" required>
            </div>
            <div class="col-md-6">
                <label for="vacantes_cantidad" class="form-label">Cantidad de vacantes</label>
                <input type="number" class="form-control" id="vacantes_cantidad" name="vacantes_historico[0][count]" value="0" required>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">Crear Empresa</button>
                <a href="{{ route('empresas.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
            </div>
        </form>
    </div>
@endsection 