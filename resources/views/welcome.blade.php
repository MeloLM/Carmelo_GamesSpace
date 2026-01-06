<x-layout>
    
    <div class="container-fluid bg-transparent mainBg ">
        
        {{-- ALERT SECTION --}}
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
        @if (session('Sented'))
        <div class="alert alert-success alert-dismissible fade show border-start border-end" role="alert">
            {{ session('Sented') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        {{-- HEADER --}}
        <div class="row p-4  justify-content-center">
            <div class="col-12 col-md-8 p-5">
                <h2 class="font1 text-white text-center h1">
                    Welcome to Souls Space
                </h2>
                {{-- <p class="text-white text-center mt-5 mb-4 h4">Qui troverai recensioni dettagliate dei giochi Dark Souls, guide per affrontare i boss più difficili, analisi approfondite dei personaggi, delle armi e degli oggetti, e molto altro ancora. Ci concentreremo anche sulle teorie della trama e sulle connessioni tra i vari personaggi e luoghi del mondo di Dark Souls.</p>                --}}
                <p class="text-white text-center mt-5 mb-4 h4">Here you will find detailed reviews of Dark Souls games, guides to tackle the toughest bosses, in-depth analysis of characters, weapons and items, and much more. We will also focus on theories of the plot and connections between the various characters and locations in the world of Dark Souls.</p>               
                
            </div>
        </div>
        <div class="row justify-content-center">
            {{-- BUTTON --}}
            <div class="col-10 col-md-2 mx-md-5">     
                <button class="button mt-4 ">
                    <a href="{{route('game.index')}}" class="text-decoration-none">
                        <span class="button_lg">
                            <span class="button_sl"></span>
                            <span class="button_text">Games</span>
                        </span>
                    </a>
                </button>
            </div>
            <div class="col-10 col-md-2 mx-md-5">           
                <a href="{{route('console.index')}}" class="text-decoration-none">
                    <button class="button mt-4">
                        <span class="button_lg">
                            <span class="button_sl"></span>
                            <span class="button_text">Boss area</span>
                        </span>
                    </button>  
                </a>
            </div>
        </div>
    </div>
    
    
    
    <div class="container-fluid sectionBg">
        <div class="row px-5 justify-content-around">
            <div class="col-12 col-md-5 mb-5 d-flex align-items-center">
                <div class="card1 cardIn d-flex justify-content-center align-items-center rounded-4">
                    <h3 class="display-3 textMain">Dark Souls</h3>
                </div>
            </div>
            <div class="col-12 col-md-5 mb-5 d-flex align-items-center">
                <div class="card2 cardIn d-flex justify-content-center align-items-center rounded-4">
                    <h3 class="display-3 textMain">Demon Souls</h3>
                </div>
            </div>
        </div>
    </div>
    
    
</x-layout>