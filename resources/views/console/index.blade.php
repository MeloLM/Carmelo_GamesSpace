<x-layout>
    
    
    <div class="container-fluid mainBg text-white">
        <div class="row p-3 ">
            @if (session('consoleCreated'))
            <div class="alert alert-success alert-dismissible fade show border-start border-end" role="alert">
                {{ session('consoleCreated') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session('consoleDeleted'))
            <div class="alert alert-danger alert-dismissible fade show border-start border-end" role="alert">
                {{ session('consoleDeleted') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="col-12  ">
                <h2 class="display-4 text-center">
                    Consoles
                </h2>
            </div>
            
        </div>
    </div>
    
    <div class="container-fluid bg-dark">
        <div class="row justify-content-center">
            @foreach($consoles as $console)
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
                        <p class="card-text   fs-6">by {{$console->user->name}}</p>
                        <a href="{{route('console.show', compact('console'))}}" class="btn btn-dark">More info...</a>
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