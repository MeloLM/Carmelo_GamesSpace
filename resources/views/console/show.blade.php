
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
                        <p class="card-text fs-6">by Carmelo La Mantia</p>
                        <p class="">{{$console->description}}</p>
                        <a href="{{route('console.index')}}" class="stretched-link text-danger">Torna indietro</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-layout>