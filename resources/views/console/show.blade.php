
<x-layout>
    
    <div class="container-fluid bg-dark text-white d-flex justify-content-center">
        <div class="row p-3 ">
            <div class="col-12  ">
                <h2>
                    Details Console:
                </h2>
            </div>
            
        </div>
    </div>
    
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
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

                        <hr>

                        <p>I giochi disponibili sono:</p>  
                        <ul class="">
                            @foreach ($console->games as $game)
                            <li class="text-muted">{{$game->title}}, prodotto da {{$game->product}}, di prezzo {{$game->price}} € </li>
                            @endforeach
                        </ul>

                        <hr>

                        <p class="">{{$console->description}}</p>
                        <a href="{{route('console.index')}}" class="btn btn-dark">Go Back</a>

                        @if (Auth::user() && Auth::id() == $console->user_id)
                            <a href="{{route('console.edit', compact('console'))}}" class="btn btn-warning ms-5 ">Edit</a>
                            <form action="{{route('console.destroy', compact('console'))}}" method="POST" class="d-inline">
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