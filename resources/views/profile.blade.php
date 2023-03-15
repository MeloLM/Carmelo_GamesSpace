<x-layout>
    
    <div class="container-fluid bg-dark text-white d-flex justify-content-center">
        <div class="row p-3 ">
            <div class="col-12 ">
                <h2>
                    Welcome to your Profile
                </h2>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <h2>Inserisci avatar</h2>
                <form action="{{route('changeAvatar', ['user'=> Auth::user()])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    
                    <input type="file" name="avatar" class="form-control">
                    <button type="submit" class="btn btn-dark">Inserisci avatar</button>
                </form>
            </div>
        </div>
    </div>
    
    @if (session('gameCreated'))
    <div class="alert alert-success alert-dismissible fade show border-start border-end" role="alert">
        {{ session('gameCreated') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="container-fluid">
        <img style="width: 50px; border-radius:50%;" src="{{Storage::url(Auth::user()->avatar)}}" class="m-3" alt="...">
        <div class="row justify-content-center">
            <h2>Your console:</h2>
            @foreach(Auth::user()->consoles as $console)
            <div class="col-12 col-md-3">
                <div class="card custom-card mt-5">
                    @if (!$console->logo)
                    <img src="https://picsum.photos/300/200" class="img-fluid card-img-top" alt="...">
                    @else
                    <img src="{{Storage::url($console->logo)}}" class="img-fluid card-img-top" alt="...">
                    @endif  
                    <div class="p-1 text-dark" >
                        <h5>{{$console->name}}</h5>
                        <h6 class="fst-italic text-muted">{{$console->brand}}</h6>
                        <p class="card-text fs-6">by {{$console->user->name}}</p>
                        <a href="{{route('console.show', compact('console'))}}" class="btn btn-dark">More info..</a>
                        <a href="{{route('console.edit', compact('console'))}}" class="btn btn-warning">Edit</a>
                        <form action="{{route('console.destroy', compact('console'))}}" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row justify-content-center">
            <h2>Your games:</h2>
            @foreach(Auth::user()->games as $game)
            <div class="col-12 col-md-3">
                <div class="card custom-card mt-5">
                    @if (!$game->cover)
                    <img src="https://picsum.photos/300/200" class="img-fluid card-img-top" alt="...">
                    @else
                    <img src="{{Storage::url($game->cover)}}" class="img-fluid card-img-top" alt="...">
                    @endif  
                    <div class="p-1 text-dark" >
                        <h5>{{$game->title}}</h5>
                        <h6 class="fst-italic text-muted">{{$game->product}}</h6>
                        <h6 class="text-muted">{{$game->price}} €</h6>+
                        
                        <p class="card-text fs-6">by {{$game->user->name}}</p>
                        <a href="{{route('game.show', compact('game'))}}" class="btn btn-dark">More info..</a>
                        <a href="{{route('game.edit', compact('game'))}}" class="btn btn-warning">Edit</a>
                        <form action="{{route('game.destroy', compact('game'))}}" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
</x-layout>