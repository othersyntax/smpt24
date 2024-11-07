<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
        <li class="nav-item ">
            <a href="{{ route('dashboard') }}" class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('tanah-senarai') }}" class="nav-link {{ (request()->segment(1) == 'tanah') ? 'active' : '' }}">
                <i class="nav-icon fas fa-map"></i>
                <p>Data Tanah</p>
            </a>
        </li>               
        <li class="nav-item">
            <a href="/premis/senarai" class="nav-link {{ (request()->segment(1) == 'premis') ? 'active' : '' }}">
                <i class="nav-icon fas fa-landmark"></i>
                <p>Premis Demis</p>
            </a>
        </li>
        @if (session('loginRole')==1)                  
        <li class="nav-item {{ (request()->segment(1) == 'utiliti') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->segment(1) == 'utiliti') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
                Pentadbiran
                <i class="fas fa-angle-left right"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">                
                <li class="nav-item">
                    <a href="/utiliti/negeri/senarai" class="nav-link {{ (request()->segment(2) == 'negeri') ? 'active' : '' }}">
                    <i class="fas fa-globe nav-icon"></i>
                    <p>Kod Negeri</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/utiliti/daerah/senarai" class="nav-link {{ (request()->segment(2) == 'daerah') ? 'active' : '' }}">
                    <i class="fa fa-map-marker nav-icon"></i>
                    <p>Kod Daerah</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/utiliti/mukim/senarai" class="nav-link {{ (request()->segment(2) == 'mukim') ? 'active' : '' }}">
                    <i class="fas fa-building nav-icon"></i>
                    <p>Kod Bandar</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/utiliti/ptj/senarai" class="nav-link {{ (request()->segment(2) == 'ptj') ? 'active' : '' }}">
                    <i class="fas fa-building nav-icon"></i>
                    <p>Senarai JKN / PTJ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengguna-senarai') }}" class="nav-link {{ (request()->segment(2) == 'pengguna') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Senarai Pengguna</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/utiliti/jenis/isu/senarai" class="nav-link {{ (request()->segment(2) == 'jenis') ? 'active' : '' }}">
                    <i class="fas fa-file nav-icon"></i>
                    <p>Senarai Jenis Isu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/utiliti/hakmilik/senarai" class="nav-link {{ (request()->segment(2) == 'hakmilik') ? 'active' : '' }}">
                    <i class="fas fa-atlas nav-icon"></i>
                    <p>Senarai Hak Milik</p>
                    </a>
                </li>
            </ul>
        </li>
        @endif 
        <li class="nav-item">
            <a href="/auth/logout" class="nav-link">
                <i class="nav-icon fas fa-times-circle"></i>
                <p>Logout</p>
            </a>
        </li>
    </ul>
</nav>