<x-layout>
    
    <div class="container-fluid bg-dark text-white d-flex justify-content-center">
        <div class="row p-3 ">
            <div class="col-12  ">
                <h2>
                    Welcome to GamesSpace
                </h2>
            </div>
            
        </div>
    </div>
    @if (session('gameCreated'))
    <div class="alert alert-success alert-dismissible fade show border-start border-end" role="alert">
        {{ session('gameCreated') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    {{-- nel form mettere solo {{fillable}} --}}
    {{-- <x-card 

        :game = "$game"  PER DATI PIU' COMPLESSI

    title="{{$game['title']}}"
    product="{{$game['product']}}"
    price=" {{$game['price']}}"
    /> --}}


    <div class="container">
        <div class="row justify-content-center">
            @foreach($games as $game)
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
                        <h6 class="text-muted">{{$game->price}} €</h6>
                        <p class="card-text   fs-6">by Carmelo La Mantia</p>
                        {{-- <a href="#" class="stretched-link text-danger">Leggi di più</a> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</x-layout>