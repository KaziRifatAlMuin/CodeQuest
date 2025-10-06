<x-layout>
    <x-slot:title>User Details - CodeQuest</x-slot:title>
    <h1 class="display-4"> User Details </h1>
    <p class="lead">Details of user with ID: {{ $user['id'] }}</p>
    <ul>
        <li>Name: {{ $user['name'] }}</li>
        <li>Rating: {{ $user['rating'] }}</li>
    </ul>

    <a href="/users">Back to Users List</a>

</x-layout>