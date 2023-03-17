<x-layout>
    
    
    <div class="container-fluid formBg">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <form class="p-5 shadow text-white" action="{{route('games.store')}}" method="POST" enctype="multipart/form-data">
                    <h3 class="display-4">Inserisci un Gioco</h3>
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
                    <div class="mb-3">
                        <label for="title" class="form-label">Nome gioco</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}" placeholder="es. Bloodborne, Tekken X..">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Prezzo</label>
                        <input type="float" class="form-control" name="price" id="price" value="{{old('price')}}" placeholder="00.00">
                    </div>
                    <div class="mb-3">
                        <label for="product" class="form-label">Brand</label>
                        <input type="text" class="form-control" name="product" id="product" value="{{old('product')}}" placeholder="es. Konami, Atari..">
                    </div>
                    <div class="mb-3">
                        <label for="cover" class="form-label">Copertina</label>
                        <input type="file" class="form-control" name="cover" id="cover" placeholder="...">
                    </div>
                    <div class="mb-3">
                        <label for="consoles" class="form-label">Console compatibili:</label>
                        <select name="console[]" id="consoles" class="form-contol" multiple>
                            @foreach ($consoles as $console)
                                <option value="{{$console->id}}"></option>                                
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{old('description')}}</textarea>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Aggiungi Gioco</button>
                        <a href="{{route('game.index')}}" class="btn btn-secondary">Torna ai giochi</a>
                    </div>
                </form>
            </div>    
        </div>    
    </div>    
</x-layout>