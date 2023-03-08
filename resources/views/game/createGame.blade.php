<x-layout>
    
    
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <form class="p-5 shadow" action="{{route('games.store')}}" method="POST" enctype="multipart/form-data">
                    
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
                        <label for="description" class="form-label">Descrizione</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{old('description')}}</textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-danger bg-main">Aggiungi Gioco</button>
                        <a href="{{route('homepage')}}" class="btn btn-outline-main">Torna alla Home</a>
                    </div>
                </form>
            </div>    
        </div>    
    </div>    
</x-layout>