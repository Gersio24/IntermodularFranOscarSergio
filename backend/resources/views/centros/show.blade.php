@extends('partials.plantilla')

@section('titulo', 'Detalles del Centro')

@section('contenido')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-0">{{ $centro->nombre }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('centros.index') }}">Centros</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalles</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('centros.edit', $centro) }}" class="btn btn-warning">
                <i class="bi bi-pencil-fill me-1"></i> Editar Centro
            </a>
            <form action="{{ route('centros.destroy', $centro) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('¿Está seguro de que desea eliminar este centro? Esta acción no se puede deshacer.')">
                    <i class="bi bi-trash-fill me-1"></i> Eliminar Centro
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle-fill me-2"></i>Información de Contacto
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">
                            <a href="mailto:{{ $centro->email }}" class="text-decoration-none">
                                {{ $centro->email }}
                            </a>
                        </dd>

                        <dt class="col-sm-4">Teléfono:</dt>
                        <dd class="col-sm-8">
                            <a href="tel:{{ $centro->telefono }}" class="text-decoration-none">
                                {{ $centro->telefono }}
                            </a>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-geo-alt-fill me-2"></i>Ubicación
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Dirección:</dt>
                        <dd class="col-sm-8">{{ $centro->direccion }}</dd>

                        <dt class="col-sm-4">Población:</dt>
                        <dd class="col-sm-8">{{ $centro->poblacion }}</dd>

                        <dt class="col-sm-4">Provincia:</dt>
                        <dd class="col-sm-8">{{ $centro->provincia }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    @if($centro->usuarios->count() > 0)
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">
                <i class="bi bi-people-fill me-2"></i>Usuarios Asociados
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($centro->usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->nombre }}</td>
                                <td>
                                    <a href="mailto:{{ $usuario->email }}" class="text-decoration-none">
                                        {{ $usuario->email }}
                                    </a>
                                </td>
                                <td>{{ $usuario->roles->pluck('nombre')->implode(', ') }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Ver detalles del usuario">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <div class="d-flex justify-content-center">
        <a href="{{ route('centros.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
        </a>
    </div>
</div>

@push('scripts')
<script>
    // Inicializar tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection 