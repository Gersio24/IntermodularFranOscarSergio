@extends('partials.plantilla')

@section('titulo', 'Ver Empresa')
@section('contenido')
    <div class="container">
        <h1>Detalles de la Empresa</h1>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h2>{{ $empresa->nombre }}</h2>
                        <hr>
                        <div class="mb-3">
                            <strong>Email:</strong> {{ $empresa->email }}
                        </div>
                        <div class="mb-3">
                            <strong>Teléfono:</strong> {{ $empresa->telefono }}
                        </div>
                        <div class="mb-3">
                            <strong>Dirección:</strong><br>
                            {{ $empresa->direccion_calle }}<br>
                            {{ $empresa->poblacion }}, {{ $empresa->direccion_provincia }}
                        </div>
                        <div class="mb-3">
                            <strong>Horario:</strong> {{ $empresa->horario_inicio }} - {{ $empresa->horario_fin }}
                        </div>
                        
                        @if($empresa->categorias)
                        <div class="mb-3">
                            <strong>Categorías:</strong><br>
                            @foreach($empresa->categorias as $categoria)
                                <span class="badge bg-primary me-1">{{ $categoria }}</span>
                            @endforeach
                        </div>
                        @endif
                        
                        @if($empresa->servicios)
                        <div class="mb-3">
                            <strong>Servicios:</strong><br>
                            @foreach($empresa->servicios as $servicio)
                                <span class="badge bg-secondary me-1">{{ $servicio }}</span>
                            @endforeach
                        </div>
                        @endif
                        
                        @if($empresa->vacantes_historico)
                        <div class="mb-3">
                            <strong>Historial de Vacantes:</strong><br>
                            <ul class="list-unstyled">
                                @foreach($empresa->vacantes_historico as $vacante)
                                    <li>{{ $vacante['year'] }}: {{ $vacante['count'] }} vacantes</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <strong>Puntuaciones:</strong><br>
                            Profesores: {{ number_format($empresa->puntuacion_profesor, 2) }}/100<br>
                            Alumnos: {{ number_format($empresa->puntuacion_alumno, 2) }}/100
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        @if($empresa->imagen)
                            <img src="{{ $empresa->imagen }}" alt="{{ $empresa->nombre }}" class="img-fluid rounded">
                        @endif
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('empresas.edit', $empresa) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('empresas.destroy', $empresa) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta empresa?')">Eliminar</button>
                    </form>
                    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Volver al listado</a>
                </div>
            </div>
        </div>
    </div>
@endsection 