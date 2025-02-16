@extends('partials.plantilla')

@section('titulo', 'UsuEdit')
@section('contenido')

    <h1 class="text-center">Panel de administrador</h1>

    @auth
        <p class="text-center">Bienvenido, {{ Auth::user()->nombre }}!</p>
    @endauth
@endsection
