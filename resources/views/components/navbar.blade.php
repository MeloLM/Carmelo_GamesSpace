<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Game Spaces</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{route('homepage')}}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{route('console.index')}}">Console</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="{{route('console.create')}}">Add Console</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="{{route('createGame')}}">Add Games</a>
        </li>
      </ul>
      
      
      <ul class="navbar-nav ms-5 mb-2 mb-lg-0 ">
        @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Benvenuto {{Auth::user()->name}} 
           
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('profile')}}">Profilo</a></li>
            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.querySelector('#form-logout').submit();" >Esci</a></li>
            <form id="form-logout" action="{{route('logout')}}" method="POST" class="d-none">@csrf</form>
          </ul>
        </li>
        @else
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Benvenuto Guest
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('register')}}">Registrati</a></li>
            <li><a class="dropdown-item" href="{{route('login')}}">Login</a></li>      
          </ul>
        </li>
        @endauth
      </ul>
      
    </div>
  </div>
</nav>


