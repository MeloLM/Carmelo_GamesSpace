
<x-layout>
    
    <div class="container-fluid profileBg">
        <div class="row p-3 ">
            <div class="col-12 mt-5 text-center text-white">
                <h2>
                    Details Console:
                </h2>
            </div>
            
        </div>
    </div>
    
    
    <div class="container-fluid profileBg2">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                <div class=" mt-5">
                    @if (!$console->logo)
                    <img src="https://picsum.photos/300/200" class="img-fluid card-img-top" alt="...">
                    @else
                    <img src="{{Storage::url($console->logo)}}" class="img-fluid card-img-top rounded-1" alt="...">
                    @endif  
                    <div class="p-1 text-dark d-flex justify-content-around">
                        
                        <a href="{{route('console.index')}}" class="btn btn-secondary">Go Back</a>
                        
                        @if (Auth::user() && Auth::id() == $console->user_id)
                        <a href="{{route('console.edit', compact('console'))}}" class="btn btn-warning">Edit</a>
                        <form action="{{route('console.destroy', compact('console'))}}" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5 text-white mt-5">
                <h5>{{$console->name}}</h5>
                <h6 class="fst-italic text-muted">{{$console->brand}}</h6>
                <a href="{{route('profile',['user'=>$console->user->id])}}" class="text-white text-decoration-none lead fs-6">by {{$console->user->name}}</a>
                
                @if (count($console->games) > 0)
                <hr>
                    <p>I giochi disponibili sono:</p>  
                    <ul class="">
                        @foreach ($console->games as $game)
                            <li class="text-muted">{{$game->title}}, prodotto da {{$game->product}}, di prezzo {{$game->price}} € </li>
                        @endforeach
                    </ul>
                <hr>
                @endif
                <p>{{$console->description}}</p>
            </div>
        </div>
    </div>
    
</x-layout>