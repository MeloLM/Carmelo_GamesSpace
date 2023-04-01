<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <title>Souls Space</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    
    <x-navbar 
    /> 
    
    <main class="min-vh-100">
        {{$slot}}
    </main>
    
    <x-footer 
    />
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
</body>
</html>