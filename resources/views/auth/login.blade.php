<x-layout>
    
    <div class="container-fluid  loginBg">
        <div class="row pt-5 justify-content-center">
            <div class="col-12 mt-5 col-md-8">
        
                <form class="p-5 shadow bg-dark text-white rounded-3" action="{{route('login')}}" method="POST"> 
                    
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
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="...">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label" for="remember" >Ricordami</label>
                      </div>
                    <button type="submit" class="btn btn-ds" >Accedi</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>