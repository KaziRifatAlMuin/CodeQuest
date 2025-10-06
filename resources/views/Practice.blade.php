<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
    <h1> This is Practice Page </h1>
    <a href="{{ url('welcome') }}"> welcome </a> <br>
    <a href="{{ url('about') }}"> About </a> <br>
    <a href="{{ url('contact') }}"> Contact </a> <br>
    <a href="{{ url('/') }}"> Home </a><br>
</body>
</html>
