<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Gestión FCT</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto"> <!-- Aquí se alinean los items a la izquierda -->
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin')}}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="}}">Empresas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('usuarios')}}">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('formulario')}}">Formularios</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto"> <!-- Aquí se alinean los items a la derecha -->
                <li class="nav-item">
                    <a class="nav-link link-underline-dark" href="{{route('logout')}}">Cerrar Sesion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
