<nav class="main-header navbar navbar-expand navbar-info navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link text-white" data-toggle="dropdown" href="#">
            <div class="media">
                <img src="/storage/{{ auth()->user()->imagen }}" class="img-circle mr-2" style="width: 30px"
                  alt="User Image">
                <div class="media-body">
                    <span class="hidden-xs">{{ Auth::user()->nombreCompleto }}</span>
                </div>
              </div>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">
                <img src="/storage/{{ auth()->user()->imagen }}" class="img-circle img-size-50"
                  alt="User Image">
            </span>
            <div class="dropdown-divider"></div>

            <a href="{{ route('usuarios.show', Auth::user()->id) }}" class="dropdown-item">
                <i class="fas fa-id-card-alt mr-2"></i>
                <em>Ver Mi Perfil</em>
            </a>

            <div class="dropdown-divider"></div>
            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <em>Cerrar sesión</em>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                style="display: none;">
                @csrf
            </form>
          </div>
        </li>
    </ul>
</nav>
