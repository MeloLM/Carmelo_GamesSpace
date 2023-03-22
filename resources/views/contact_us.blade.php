<x-layout>
    
    <div class="container-fluid profileBg2">
        <div class="row justify-content-center text-white pt-5">
            <div class="col-12 col-md-6">
                <h3 class="text-center">Contattaci</h3>
                
                <form id="my_form" action="{{route('contact_us_submit')}}" method="POST" class=" pt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Completo</label>
                        <input type="name" class="form-control" id="name" name="name" placeholder="es. Oscar da Astora">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="sigwaier@katarina.com">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                    </div>    
                </form>
                <div class="d-flex justify-content-between my-4">
                    <button type="submit" form="my_form" class="btn btn-ds">Contattaci</button>
                    <a href="{{route('homepage')}}" class="btn btn-secondary">Torna alla Home</a>
                </div>
                
            </div>
        </div>
    </div>
    
    
    
    
</x-layout>