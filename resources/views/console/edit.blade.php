<x-layout>
    
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                
                <form class="p-5 shadow" action="{{route('console.update',compact('console'))}}" method="POST" enctype="multipart/form-data"> 
                    <h3 class="display-3 text-center">Modifica Gioco:</h3>
                    
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-start border-end">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    @csrf

                    @method('put')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Console:</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand:</label>
                        <input type="text" class="form-control" name="brand" id="brand">
                    </div>
                    <div class="mb-3">
                        <label for="existingLogo" class="form-label fontor fs-3"> Immagine attuale:</label>
                        <img src="{{Storage::url($console->logo)}}" alt="..">
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Nuova foto console:</label>
                        <input type="file" class="form-control" name="logo" id="logo">
                    </div>
                    <div class="mb-3">
                        <label for="game">Giochi disponibili:</label>
                        <select name="game" id="game" class="form-control">
                            @foreach ($games as $game)
                            <option value="{{$game->id}}">
                                {{$game->title}}
                            </option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione:</label>
                        <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-outline-danger" >Inserisci modifica</button>
                    <button href="{{route('console.index')}}" type="submit" class="btn btn-outline-info" >Torna alle vendite</button>
                    
                </form>
            </div>
        </div>
    </div>
</x-layout>