<x-layout>
    
    <div class="container-fluid formBg">
        <h3 class="display-3 text-white text-center">Modifica annuncio</h3>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                
                <form id="my-form" class="p-5 text-white" action="{{route('game.update',compact('game'))}}" method="POST" enctype="multipart/form-data"> 
                    
                    
                    
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
                        <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Prezzo:</label>
                        <input type="double" class="form-control" name="price" id="price" value="{{old('price')}}">
                    </div>
                    <div class="mb-3">
                        <label for="existingCover" class="form-label fontor fs-3"> Immagine attuale</label>
                        <img src="{{Storage::url($game->cover)}}" width="300" alt="..">
                    </div>
                    <div class="mb-3">
                        <label for="cover" class="form-label">Foto gioco nuova:</label>
                        <input type="file" class="form-control" name="cover" id="cover">
                    </div>
                    <div class="mb-3">
                        <label for="console">Console disponibili:</label>
                        <select name="console" id="console" class="form-control">
                            @foreach ($consoles as $console)
                            <option value="{{$console->id}}">
                                {{$console->name}}
                            </option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione del gioco:</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{old('description')}}</textarea>
                    </div>
                </form>

                
                <div class="d-flex justify-content-between mb-3">
                    <button type="submit" form="my-form" class="btn btn-ds">Inserisci modifica</button>
                    <a href="{{route('game.index')}}" class="btn btn-secondary">Torna ai giochi</a>
                </div>
                
                

            </div>
        </div>
    </div>
</x-layout>