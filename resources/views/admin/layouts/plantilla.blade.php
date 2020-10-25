<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plantilla.css') }}" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper" id="app">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @auth
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/home" class="brand-link">
                <img src="/logo-scm.png" alt="Sistema de citas medicas" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">S.C.M.</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 text-center">
                    <div class="image">
                        <img src="/storage/{{ auth()->user()->imagen }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item has-treeview menu-open">
                                <a href="#" class="nav-link">
                                    {{-- <i class="nav-icon fas fa-user"></i> --}}
                                    <p>
                                        {{ Auth::user()->nombreCompleto }}
                                        {{-- <i class="right fas fa-angle-left"></i> --}}
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('usuarios.show', Auth::user()->id) }}" class="nav-link">
                                            {{-- <i class="fas fa-arrow-right nav-icon"></i> --}}
                                            <em>Mi Perfil</em>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                                            {{-- <i class="fas fa-arrow-right nav-icon"></i> --}}
                                            <em>Cerrar sesión</em>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview">
                            <a href="/home" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    INICIO
                                </p>
                            </a>
                        </li>

                        @if (auth()->user()->tieneRol(['admin']))
                        <li class="nav-item">
                            <a href="{{ route('usuarios.index') }}"
                                class="nav-link {{ request()->is('usuarios') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Usuarios
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('medicos.index') }}"
                                class="nav-link {{ request()->is('medicos') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-md"></i>
                                <p>
                                    Médicos
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pacientes.index') }}"
                                class="nav-link {{ request()->is('pacientes') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-injured"></i>
                                <p>
                                    Pacientes
                                </p>
                            </a>
                        </li>




                        {{-- <li class="nav-header">ADMINISTRATIVO</li> --}}
                        <div class="border border-primary"></div>
                        <li class="nav-item">
                            <a href="{{ route('especialidad.index') }}"
                                class="nav-link {{ request()->is('especialidad') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-hand-holding-medical"></i>
                                <p>
                                    Especialidades
                                </p>
                            </a>
                        </li>
                        @endif
                        @if (auth()->user()->tieneRol(['medico']))
                        <li class="nav-item">
                            <a href="{{ route('horarios.edit', auth()->user()->id) }}"
                                class="nav-link {{ request()->is('horarios*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>
                                    Horarios
                                </p>
                            </a>
                        </li>
                        <div class="border border-primary"></div>
                        @endif
                        <li class="nav-item has-treeview menu-open">
                            <a href="#" class="nav-link {{ request()->is('citas*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-clock"></i>
                                <p>
                                    CITAS
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('citas.pendientes') }}"
                                        class="nav-link {{ request()->is('citas/pendientes') ? 'active' : '' }}">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <p>Pendientes</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('citas.confirmadas') }}"
                                        class="nav-link {{ request()->is('citas/confirmadas') ? 'active' : '' }}">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <p>Confirmadas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('citas.historial') }}"
                                        class="nav-link {{ request()->is('citas/historial') ? 'active' : '' }}">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <p>Historial</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        @endauth

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">


            <!-- Main content -->
            <main class="py-4">
                @yield('content')
            </main>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    {{-- <script src="../../plugins/jquery/jquery.min.js"></script> --}}
    <!-- Bootstrap 4 -->
    {{-- <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
    <!-- AdminLTE App -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/plantilla.js') }}" defer></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="../../dist/js/demo.js"></script> --}}
    @yield('scripts')
</body>

</html>
