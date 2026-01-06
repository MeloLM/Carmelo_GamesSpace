<x-layout>
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
    
    <div class="container-fluid loginBg">
        <div class="row justify-content-center pt-5">
            <div class="col-12 col-md-8 pt-4">
                
                <form class="p-5 shadow bg-dark text-white rounded-3" action="{{route('register')}}" method="POST"> 
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Cognome:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="es. Mario Rossi">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="...">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Conferma password:</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-ds">Registrati</button>
                </form>
            </div>       
        </div>       
    </div>       
    
</x-layout>