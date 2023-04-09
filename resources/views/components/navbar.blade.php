<nav class="navbar navbar-expand-lg bg-black sticky-top navbar-dark p-2">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Souls Spaces</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse  position-relative " id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link link_custom" aria-current="page" href="{{route('homepage')}}">Home</a>
        </li>
        <li class="nav-item">
          <span>
            <a class="nav-link link_custom" href="{{route('game.index')}}">Games</a>
          </span>
        </li>
        <li class="nav-item">
          <a class="nav-link link_custom" href="{{route('console.index')}}">Bosses</a>
        </li>
        @auth
        <li class="nav-item">
          <a class="nav-link link_custom" href="{{route('console.create')}}">Add Bosses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link link_custom" href="{{route('createGame')}}">Add Games</a>
        </li>
        @endauth
      </ul>
      
      
      <ul class="navbar-nav ms-5 mb-2 mb-lg-0 ">
        <li class="nav-item">
          <a class="nav-link link_custom" href="{{route('contact_us')}}">Contact Us</a>
        </li>
        @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle link_custom" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Welcome {{Auth::user()->name}} 
           
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item link_custom" href="{{route('profile')}}">Profile</a></li>
            <li><a class="dropdown-item link_custom" href="#" onclick="event.preventDefault(); document.querySelector('#form-logout').submit();" >Esci</a></li>
            <form id="form-logout" action="{{route('logout')}}" method="POST" class="d-none">@csrf</form>
          </ul>
        </li>
        @else
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle link_custom" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Welcome Guest
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item link_custom" href="{{route('register')}}">Sign in</a></li>
            <li><a class="dropdown-item link_custom" href="{{route('login')}}">Login</a></li>      
          </ul>
        </li>
        @endauth
      </ul>
      
    </div>
  </div>
</nav>


