<x-layout>
    <x-slot:title>Practice Page</x-slot:title>

    <h1 class="display-4">This is Practice Page</h1>
    <p>Welcome to the practice section of CodeQuest. Here you can find various coding problems to solve and improve your skills.</p>
    
    <div class="mb-4">
        <a href="{{ route('welcome') }}" class="btn btn-primary mr-2">Welcome</a>
        <a href="{{ route('about') }}" class="btn btn-secondary mr-2">About</a>
        <a href="{{ route('contact') }}" class="btn btn-info mr-2">Contact</a>
        <a href="{{ route('home') }}" class="btn btn-success">Home</a>
    </div>
</x-layout>