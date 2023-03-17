<x-layout>
    
    <div class="container-fluid bg-transparent  mainBg">
        <div class="row justify-content-center align-items-center">
           
                <h2 class="display-4 text-white text-center">
                    Giochi
                </h2>
           
            @if (session('gameCreated'))
            <div class="alert alert-success alert-dismissible fade show border-start border-end" role="alert">
                {{ session('gameCreated') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if (session('gameDeleted'))
            <div class="alert alert-danger alert-dismissible fade show border-start border-end" role="alert">
                {{ session('gameDeleted') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        
        <div class="row ">
            @foreach($games as $game)
            <div class="col-12 col-md-3 mb-3">
                <div class="card custom-card mt-5 bg-dark shadow">
                    @if (!$game->cover)
                    <img src="https://picsum.photos/300/200" class="img-fluid card-img-top " alt="...">
                    @else
                    <img src="{{Storage::url($game->cover)}}" class="img-fluid card-img-top " alt="...">
                    @endif  
                    <div class="p-1 text-white">
                        <h5>{{$game->title}}</h5>
                        <h6 class="fst-italic text-muted">{{$game->product}}</h6>
                        <h6 class="text-muted">{{$game->price}} €</h6>
                        <p class="card-text fs-6">by {{$game->user->name}}</p>
                    </div>
                    <div class="d-flex">
                        <a href="{{route('game.show', compact('game'))}}" class="btn btn-dark ">More info..</a>             
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="container-fluid sectionBg">
        <div class="row">
            
        </div>
    </div>
    
    
</x-layout>