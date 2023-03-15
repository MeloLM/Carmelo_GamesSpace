<x-layout>
    
    <div class="container my-5">
        <h3 class="display-3 text-center">Modifica annuncio</h3>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                
                <form class="p-5 shadow" action="{{route('game.update',compact('game'))}}" method="POST" enctype="multipart/form-data"> 
                    
                    
                    
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
                        <label for="title" class="form-label">Nome Gioco:</label>
                        <input type="text" class="form-control" name="title" id="title">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Prezzo:</label>
                        <input type="double" class="form-control" name="price" id="price">
                    </div>
                    <div class="mb-3">
                        <label for="existingCover" class="form-label fontor fs-3"> Immagine attuale</label>
                        <img src="{{Storage::url($game->cover)}}" alt="..">
                    </div>
                    <div class="mb-3">
                        <label for="cover" class="form-label">Foto gioco nuova:</label>
                        <input type="file" class="form-control" name="cover" id="cover">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione del gioco:</label>
                        <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-outline-danger" >Inserisci modifica</button>
                    <button href="{{route('homepage')}}" type="submit" class="btn btn-outline-info" >Torna alle vendite</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>