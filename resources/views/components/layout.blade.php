<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Game Space</title>
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
    
</body>
</html>