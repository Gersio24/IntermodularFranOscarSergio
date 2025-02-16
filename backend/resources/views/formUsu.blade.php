@extends('partials.plantilla')

@section('titulo', 'UsuEdit')
@section('contenido')
<div class="container mt-4">
    @isset($usuario)
        <h1 class="mb-4">Editar Usuario</h1>

        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" class="card p-4 shadow-sm">
            @method('PUT')
            @csrf

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="{{ old('nombre', $usuario->nombre) }}" required>
                @error('nombre')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="NIF" class="form-label">NIF</label>
                <input type="text" class="form-control" name="NIF" placeholder="NIF" value="{{ old('NIF', $usuario->NIF) }}" required>
                @error('NIF')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email', $usuario->email) }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="Dejar en blanco para no modificar">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="centros" class="form-label">Centro</label>
                <select class="form-select" name="centros" id="centros">
                    <option value="">Selecciona un centro</option>
                    @foreach ($centros as $centro)
                        <option value="{{ $centro->id }}" @if (old('centros', $usuario->id_centro) == $centro->id) selected @endif>{{ $centro->nombre }}</option>
                    @endforeach
                </select>
                @error('centros')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="empresas" class="form-label">Empresa</label>
                <select class="form-select" name="empresas" id="empresas">
                    <option value="">Selecciona una empresa</option>
                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}" @if (old('empresas', $usuario->id_empresa) == $empresa->id) selected @endif>{{ $empresa->nombre }}</option>
                    @endforeach
                </select>
                @error('empresas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Roles</label><br>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="roles[]" value="1" {{ in_array(1, old('roles', $usuario->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <label class="form-check-label">Centro</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="roles[]" value="2" {{ in_array(2, old('roles', $usuario->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <label class="form-check-label">Empresa</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="roles[]" value="3" {{ in_array(3, old('roles', $usuario->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <label class="form-check-label">Tutor</label>
                </div>
                @error('roles')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-8">
                    <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('usuarios') }}" class="btn btn-secondary w-100">Cancelar</a>
                </div>
            </div>
        </form>
    @else

    <h1 class="mb-4">Crear Usuario</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <input type="text" class="form-control" name="NIF" placeholder="NIF" value="{{ old('NIF') }}" required>
            @error('NIF')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <select class="form-select" name="centros">
                <option value="">Selecciona un centro</option>
                @foreach ($centros as $centro)
                    <option value="{{ $centro->id }}" {{ old('centros') == $centro->id ? 'selected' : '' }}>{{ $centro->nombre }}</option>
                @endforeach
            </select>
            @error('centros')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <select class="form-select" name="empresas">
                <option value="">Selecciona una empresa</option>
                @foreach ($empresas as $empresa)
                    <option value="{{ $empresa->id }}" {{ old('empresas') == $empresa->id ? 'selected' : '' }}>{{ $empresa->nombre }}</option>
                @endforeach
            </select>
            @error('empresas')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="roles[]" value="1" {{ is_array(old('roles')) && in_array(1, old('roles')) ? 'checked' : '' }}>
                <label class="form-check-label">Centro</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="roles[]" value="2" {{ is_array(old('roles')) && in_array(2, old('roles')) ? 'checked' : '' }}>
                <label class="form-check-label">Empresa</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="roles[]" value="3" {{ is_array(old('roles')) && in_array(3, old('roles')) ? 'checked' : '' }}>
                <label class="form-check-label">Tutor</label>
            </div>
            @error('roles')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-8">
                <button type="submit" class="btn btn-success w-100">Guardar Usuario</button>
            </div>
            <div class="col-md-4">
                <a href="{{ route('usuarios') }}" class="btn btn-secondary w-100">Cancelar</a>
            </div>
        </div>
    </form>
    @endisset
</div>
@endsection
