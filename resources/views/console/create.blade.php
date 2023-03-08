<x-layout>
    
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <form class="p-5 shadow" action="{{route('console.store')}}" method="POST" enctype="multipart/form-data">
                    
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
                        <label for="name" class="form-label">Nome console</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="es. PlayStation, Nintendo..">
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand console:</label>
                        <input type="text" class="form-control" name="brand" id="brand" value="{{old('brand')}}" placeholder="es. Sony, Microsoft..">
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" name="logo" id="logo" placeholder="...">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{old('description')}}</textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-danger bg-main">Aggiungi console</button>
                        <a href="{{route('homepage')}}" class="btn btn-outline-main">Torna alla Home</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>