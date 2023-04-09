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
                        <label for="title" class="form-label">New game name:</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{$game->title}}">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input type="double" class="form-control" name="price" id="price" value="{{$game->price}}">
                    </div>
                    <div class="mb-3 d-flex">
                        <label for="existingCover" class="form-label me-5 fs-3">Actually picture:</label>
                        <img src="{{Storage::url($game->cover)}}" width="300" class="rounded-2" alt="Preview old photo">
                    </div>
                    <div class="mb-3">
                        <label for="cover" class="form-label">New game photo:</label>
                        <input type="file" class="form-control" name="cover" id="cover">
                    </div>
                    <div class="mb-3">
                        <label for="console">Boss of the game:</label>
                        <select name="console" id="console" multiple class="form-control overflow-hidden">
                            @foreach ($consoles as $console)
                                <option value="{{$console->id}}" 
                                @if ($game->consoles->contains($console)) selected @endif
                                >
                                    {{$console->name}}
                                </option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{$game->description}}</textarea>
                    </div>
                </form>
               
                <div class="d-flex justify-content-between mb-3">
                    <button type="submit" form="my-form" class="btn btn-ds">Update this game</button>
                    <a href="{{route('game.index')}}" class="btn btn-secondary">Go to back</a>
                </div>
                
                

            </div>
        </div>
    </div>
</x-layout>