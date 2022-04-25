<!-- Navbar -->
<nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
<!-- Container wrapper -->
<div class="container-fluid">
  <!-- Toggler -->
  <a class="ripple d-flex justify-content-center py-3" href="#!" data-mdb-ripple-color="primary">
    <img id="logo" src="{{ asset('images/apex-purple-horizontal.png') }}"
      alt="Logo" draggable="false" height="25" />
  </a>

  <!-- Search form -->
  {{-- <form class="d-none d-md-flex justify-content-center mx-auto input-group w-auto my-auto">
    <input autocomplete="off" type="search" class="form-control rounded" placeholder='Search'
      style="min-width: 225px;" />
    <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
  </form> --}}

  <!-- Right links -->
  <ul class="navbar-nav d-flex align-items-center flex-row">
    <li class="nav-item">
      <a class="nav-link me-3 py-1" href="#" data-mdb-toggle="tooltip" title="Create">
        <i class="fas fa-plus"></i>
      </a>
    </li>
    <li class="nav-item me-3">
      <a class="nav-link py-1" href="#" data-mdb-toggle="tooltip" title="Notifications">
        <i class="fas fa-bell"></i>
      </a>
    </li>

    <!-- Avatar -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center py-1" href="#"
        id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
        <img src="https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg" class="rounded-circle" height="30"
          alt="" loading="lazy" />
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink"
        style="min-width: 19rem;">
        <li>
          <div class="px-3 pt-3 d-flex">
            <img src="https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg" class="rounded-circle me-3"
              height="40" alt="" loading="lazy" />
            <div>
              <h6 class="mb-0">{{ $authenticated->name }}</h6>
              <p class="mb-2">{{ $authenticated->email }}</p>
              <a class="mb-0" href="">Manage your account</a>
            </div>
          </div>
          <hr class="mb-2">
        </li>
        <li><a class="dropdown-item" href="#"><i class="fas fa-cog fa-fw me-3"></i><span>{{ __('Settings')}}</span></a></li>
        <li><a class="dropdown-item" href="#"><i
              class="fas fa-question-circle fa-fw me-3"></i><span>{{ __('Help') }}</span></a></li>
        <li><a class="dropdown-item" href="#"><i class="fas fa-comment-alt fa-fw me-3"></i><span>{{ __('Send feedback') }}</span></a></li>
        <hr class="mb-2">
        <li>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-3"></i>
                    {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
      </ul>
    </li>
  </ul>
</div>
<!-- Container wrapper -->
</nav>
<!-- Navbar -->
