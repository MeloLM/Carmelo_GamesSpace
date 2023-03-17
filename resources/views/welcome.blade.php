<x-layout>
    
    <div class="container-fluid bg-transparent d-flex justify-content-center mainBg ">
        <div class="row p-5 ">
            <div class="col-12 p-5">
                <h2 class="font1 text-white ">
                    Welcome to Souls Space
                </h2>
            </div>
            
        </div>
    </div>
    

    @if (session('accessDenied'))
    <div class="alert alert-danger alert-dismissible fade show border-start border-end" role="alert">
        {{ session('accessDenied') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (session('userDeleted'))
    <div class="alert alert-danger alert-dismissible fade show border-start border-end" role="alert">
        {{ session('userDeleted') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="container-fluid sectionBg">
        <div class="row">

        </div>
    </div>


</x-layout>