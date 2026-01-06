
<x-layout>
    
    <div class="container-fluid profileBg">
        <div class="row p-3 mt-5">
            <div class="col-12 text-center text-white">
                <h2>
                    Details game:
                </h2>
            </div>
            
        </div>
    </div>
    
    <div class="container-fluid profileBg2">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                <div class=" mt-3">
                    @if (!$game->cover)
                    <img src="https://picsum.photos/300/200" class="img-fluid card-img-top" alt="...">
                    @else
                    <img src="{{Storage::url($game->cover)}}" class="img-fluid card-img-top rounded"  alt="...">
                    @endif  
                    <div class="p-1 text-white d-flex justify-content-around" >
                        
                        <a href="{{route('game.index')}}" class="btn btn-secondary">To Games</a>
                        
                        @if (Auth::user() && Auth::id() == $game->user_id)
                        <a href="{{route('game.edit', compact('game'))}}" class="btn btn-warning ">Edit</a>
                        <form action="{{route('game.destroy', compact('game'))}}" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5 mt-3 text-white">
                <h5>{{$game->title}}</h5>
                <h6 class="fst-italic text-muted">{{$game->product}}</h6>
                <h6 class="text-muted mt-3">{{$game->price}} €</h6>
                
                @if (count($game->consoles) > 0)
                <hr>
                    <p>Boss in the game:</p>  
                    <ul class="">
                        @foreach ($game->consoles as $console)
                            <li class="text-muted">{{$console->name}}, weak to [{{$console->brand}}]</li>
                        @endforeach
                    </ul>
                <hr>
                @endif
                    
                <p class="mb-5">{{$game->description}}</p>
                <a href="{{route('profile',['user'=>$game->user->id])}}" class="text-white text-decoration-none fs-6 mt-5">by {{$game->user->name}}</a>
            </div>
        </div>
    </div>
    
</x-layout>