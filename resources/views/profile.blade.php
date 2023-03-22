<x-layout>
    
    <div class="container-fluid profileBg text-white text-center">
        <div class="row p-3 mt-5">
            <div class="col-12 ">
                <h2>
                    Welcome to your Profile
                </h2>
            </div>
        </div>
    </div>
    
    
    
    
    <div class="container-fluid profileBg2 text-white">
        <div class="row">
            <div class="col-6">
                <img style="width: 300px; border-radius:50%;" src="{{Storage::url(Auth::user()->avatar)}}" class="m-3" alt="...">
            </div>
            <div class="col-6">
                <h2>Inserisci avatar</h2>
                <form action="{{route('changeAvatar', ['user'=> Auth::user()])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    
                    <input type="file" name="avatar" class="form-control mb-3">
                    <button type="submit" class="btn btn-warning mb-3">Inserisci avatar</button>
                </form>
                <div class="d-flex justify-content-between">
                    <form action="{{route('deleteAvatar',['user'=> Auth::user()])}}" method="POST">
                        @csrf
                        @method('put')
                        
                        <button type="submit" class="btn btn-danger mb-3">Cancella avatar</button>
                    </form>
                    <form action="{{route('user.destroy')}}" method="POST" >
                        @csrf
                        @method('delete')
                        
                        <button type="submit" class="btn btn-danger">Delete Profile</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <h2>Your console:</h2>
            @foreach($consoles as $console)
            <div class="col-12 col-md-3 ">
                <div class="card custom-card mt-5 bg-dark">
                    @if (!$console->logo)
                    <img src="https://picsum.photos/300/200" class="img-fluid card-img-top" alt="...">
                    @else
                    <img src="{{Storage::url($console->logo)}}" class="img-fluid card-img-top img_card" alt="...">
                    @endif  
                    <div class="p-1 text-white" >
                        <h5>{{$console->name}}</h5>
                        <h6 class="fst-italic text-muted">{{$console->brand}}</h6>
                        <p class="card-text fs-6">by {{$console->user->name}}</p>
                    </div>
                    <div class="d-flex justify-content-around mt-4">
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
            @foreach($games as $game)
            <div class="col-12 col-md-3 mb-3">
                <div class="card custom-card mt-5 bg-dark">
                    @if (!$game->cover)
                    <img src="https://picsum.photos/300/200" class="img-fluid card-img-top" alt="...">
                    @else
                    <img src="{{Storage::url($game->cover)}}" class="img-fluid img_card card-img-top" alt="...">
                    @endif  
                    <div class="p-1 text-white" >
                        <h5>{{$game->title}}</h5>
                        <h6 class="text-muted"></h6>
                        <h6 class="fst-italic text-muted">{{$game->product}}</h6>
                        <h6 class="text-muted">{{$game->price}} €</h6>         
                        <p class="card-text fs-6">by {{$game->user->name}}</p>
                    </div>    
                    <div class="d-flex justify-content-around">
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