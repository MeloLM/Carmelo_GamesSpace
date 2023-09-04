<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail nopreply</title>
</head>
<body class="">
    
    <h1>Hi {{$userData['name']}} </h1>
    <p>Your e-mail:<br> {{$userData['email']}}</p>
    <hr>
    <p>{{$userData['message']}}</p>

</body>
</html>