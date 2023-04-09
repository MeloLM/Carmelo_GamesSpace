<x-layout>
    
    <div class="container-fluid formBg ">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <form class="p-5 shadow text-white" action="{{route('console.store')}}" method="POST" enctype="multipart/form-data">
                    <h3 class="display-4 text-white text-center">Add a new Boss</h3>
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
                        <label for="name" class="form-label">Boss name:</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="es. Artorias ..">
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Weakness:</label>
                        <input type="text" class="form-control" name="brand" id="brand" value="{{old('brand')}}" placeholder="es. Fire-Magic-Poison ..">
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">New boss photo</label>
                        <input type="file" class="form-control" name="logo" id="logo" placeholder="...">
                    </div>
                    <div class="mb-3">
                        <label for="game" class="form-label">Avaiable games:</label>
                        <select name="games[]" id="game" class="form-control" multiple>
                            @foreach ($games as $game)
                            <option value="{{$game->id}}">
                                {{$game->title}}
                            </option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Hint:</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{old('description')}}</textarea>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <button type="submit" class="btn btn-ds ">Add new bosses</button>
                        <a href="{{route('console.index')}}" class="btn btn-secondary">Go to back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>