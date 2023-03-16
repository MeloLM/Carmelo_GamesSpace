
<x-layout>

    <div class="container-fluid bg-dark text-white d-flex justify-content-center">
        <div class="row p-3 ">
            <div class="col-12  ">
                <h2>
                   Details game:
                </h2>
            </div>
            
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                <div class="card custom-card mt-5">
                @if (!$game->cover)
                    <img src="https://picsum.photos/300/200" class="img-fluid card-img-top" alt="...">
                @else
                    <img src="{{Storage::url($game->cover)}}" class="img-fluid card-img-top" alt="...">
                @endif  
                    <div class="p-1 text-dark" >
                        <h5>{{$game->title}}</h5>
                        <h6 class="fst-italic text-muted">{{$game->product}}</h6>
                        <h6 class="text-muted">{{$game->price}} €</h6>
                        <p class="card-text fs-6">by {{$game->user->name}}</p>
                        <a href="{{route('homepage')}}" class="btn btn-primary">Back</a>

                        @if (Auth::user() && Auth::id() == $game->user_id)
                            <a href="{{route('game.edit', compact('game'))}}" class="btn btn-warning ms-5 ">Edit</a>
                            <form action="{{route('game.destroy', compact('game'))}}" method="POST" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>