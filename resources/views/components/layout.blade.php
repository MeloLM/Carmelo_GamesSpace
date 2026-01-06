<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <link rel="icon" href="/media/estus_mana.ico" type="image/ICO">
    <title>Souls Space</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body >
    <style>
        /* width */
        ::-webkit-scrollbar {
          width: 12px;
        }
        
        /* Track */
        ::-webkit-scrollbar-track {
          background: var(--second-color); 
        }
         
        /* Handle */
        ::-webkit-scrollbar-thumb {
          background: var(--main-color);
          border-radius: 10px 
        }
        
        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
          background: var(--hover-color); 
        }
        </style>
    
    <x-navbar 
    /> 

   
    {{-- <div class="burn">

      <img src="/media/borderBurn.png" class="borderBurn" alt="">
    </div> --}}
    
    <main class="min-vh-100">
        {{$slot}}
    </main>
    
    <x-footer 
    />
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
</body>
</html>