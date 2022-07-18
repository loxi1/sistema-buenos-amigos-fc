<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('logo/blue_logo_150x150.png')}}" alt="Buenos Amigos FC" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Buenos Amigos FC</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->            
                @switch(auth()->user()->roles)
                    @case('Administrador')
                    @case('Secretario')
                        <li class="nav-header">SISTEMA</li>
                        <li path="{{Request::path()}}" url="{{Request::url()}}" class="nav-item {{ (Request::is('personas*') || Request::is('socio*') || Request::is('arbitros*')) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  class="nav-link {{ (Request::is('personas*') || Request::is('socio*') || Request::is('arbitros*')) ? 'active' : '' }}"">
                                <i class="nav-icon fas fa-user-cog"></i> <p>PERSONAS <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('personas.index') }}" class="nav-link {{ Request::is('personas*') ? 'active' : '' }}">
                                        <i class="fas fa-user-friends nav-icon"></i> <p>Persona</p>
                                    </a>
                                </li>                            
                                <li class="nav-item">
                                    <a href="{{ route('arbitros.index') }}" class="nav-link {{ Request::is('arbitros*') ? 'active' : '' }}">
                                        <i class="fas fa-chalkboard-teacher nav-icon"></i> <p>Arbitro</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li path="{{Request::path()}}" url="{{Request::url()}}" class="nav-item {{ (Request::is('aperturaranios*') || Request::is('canchas*') || Request::is('socios*')) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  class="nav-link {{ (Request::is('aperturaranios*') || Request::is('canchas*') || Request::is('socios*')) ? 'active' : '' }}"">
                                <i class="nav-icon fas fa-cogs"></i> <p>CONFIGURACION <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('aperturaranios.index') }}" class="nav-link {{ Request::is('aperturaranios*') ? 'active' : '' }}">
                                        <i class="fas fa-calendar-check nav-icon"></i> <p>Aperturar Año</p>
                                    </a>
                                </li>                            
                                <li class="nav-item">
                                    <a href="{{ route('socios.index') }}" class="nav-link {{ Request::is('socios*') ? 'active' : '' }}">
                                        <i class="fas fa-chalkboard-teacher nav-icon"></i> <p>Socios</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('canchas.index') }}" class="nav-link {{ Request::is('canchas*') ? 'active' : '' }}">
                                        <i class="fas fa-map-marker-alt nav-icon"></i> <p>Canchas</p>
                                    </a>
                                </li>						  
                            </ul>
                        </li>
                        <li class="nav-header">PARTIDO</li>
                        <li class="nav-item">
                            <a href="{{ route('aperturarmes.index') }}" class="nav-link">
                                <i class="nav-icon fas fas fa-boxes"></i> <p>Aperturar mes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('asistencias.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-id-card-alt"></i> <p> Asistencia</p>
                            </a>
                        </li>
                        <li class="nav-header">CUENTAS</li>
                        <li path="{{Request::path()}}" url="{{Request::url()}}" class="nav-item {{ (Request::is('cuentasxcobrarinscripciones*') || Request::is('cuentasxcobrartarjetas*') || Request::is('cuentasxcobrarmensualidades*')) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  class="nav-link {{ (Request::is('cuentasxcobrarinscripciones*') || Request::is('cuentasxcobrartarjetas*') || Request::is('cuentasxcobrarmensualidades*')) ? 'active' : '' }}"">
                                <i class="nav-icon fas fa-donate"></i> <p>Cuentas x Cobrar <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('cuentasxcobrarinscripciones.index') }}" class="nav-link {{ Request::is('cuentasxcobrarinscripciones*') ? 'active' : '' }}">
                                        <i class="fas fa-file-import nav-icon"></i> <p>Inscripción</p>
                                    </a>
                                </li>                            
                                <li class="nav-item">
                                    <a href="{{ route('cuentasxcobrarmensualidades.index') }}" class="nav-link {{ Request::is('cuentasxcobrarmensualidades*') ? 'active' : '' }}">
                                        <i class="fas fa-clipboard-list nav-icon"></i> <p>Mensualidad</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cuentasxcobrartarjetas.index') }}" class="nav-link {{ Request::is('cuentasxcobrartarjetas*') ? 'active' : '' }}">
                                        <i class="fas fa-credit-card nav-icon"></i> <p>Tarjetas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li path="{{Request::path()}}" url="{{Request::url()}}" class="nav-item {{ (Request::is('cuentaxpagararbitrajes*') || Request::is('cuentaxpagararcanchas*')) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link  class="nav-link {{ (Request::is('cuentaxpagararbitrajes*') || Request::is('cuentaxpagararcanchas*')) ? 'active' : '' }}"">
                                <i class="nav-icon fas fa-hand-holding-usd"></i> <p>Cuentas x Pagar <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('cuentaxpagararbitrajes.index') }}" class="nav-link {{ Request::is('cuentaxpagararbitrajes*') ? 'active' : '' }}">
                                        <i class="fas fa-walking nav-icon"></i> <p>Arbitraje</p>
                                    </a>
                                </li>                            
                                <li class="nav-item">
                                    <a href="{{ route('cuentaxpagararcanchas.index') }}" class="nav-link {{ Request::is('cuentaxpagararcanchas*') ? 'active' : '' }}">
                                        <i class="fas fa-door-open nav-icon"></i> <p>Canchas</p>
                                    </a>
                                </li>                          
                            </ul>
                        </li>
                        @if(auth()->user()->roles=="Administrador")
                        <li class="nav-header">REPORTE</li>
                        <li class="nav-item">
                            <a href="{{ route('reporteinscripciones.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-signal"></i> <p>Reporte de Inscripción</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reportekardex.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-balance-scale"></i> <p>Lista Kardex</p>
                            </a>
                        </li>
                        @endif
                    @break
                    
                    @case('Usuario')
                        <li class="nav-header">APORTACIONES</li>
                        <li class="nav-item">
                            <a href="{{asset('backend/pages/gallery.html')}}" class="nav-link">
                                <i class="nav-icon far fa-image"></i><p>LISTAR MIS APORTES</p>
                            </a>
                        </li>
                    @break
                @endswitch          
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Salir') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>