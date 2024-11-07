<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="/dashboard" class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }}">Dashboard</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('tanah-senarai') }}" class="nav-link {{ (request()->segment(1) == 'tanah') ? 'active' : '' }}">Data Tanah</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('premis-senarai') }}" class="nav-link {{ (request()->segment(1) == 'premis') ? 'active' : '' }}">Premis Demis</a>
    </li>
</ul>