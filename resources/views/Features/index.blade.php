<x-layout>
    <x-slot:title>Users - CodeQuest</x-slot:title>
    <h1 class="display-4"> Users List </h1>
    <p class="lead">List of all users registered in CodeQuest.</p>
    <ul>
        @foreach ($persons as $user)
            <li>
                <a href="/user/{{ $user['id'] }}">{{ $user['name'] }} (Rating: {{ $user['rating'] }})</a>
            </li>
        @endforeach
    </ul>
</x-layout>