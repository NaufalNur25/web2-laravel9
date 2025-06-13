<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Music</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/content-card.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
    <nav>
        <a href="{{ url('/home') }}">
            <button>
                <i class="ri-home-fill"></i>
                <p>Home</p>
            </button>
        </a>
        <a href="{{ url('/create') }}">
            <button>
                <i class="ri-add-box-line"></i>
                <p>Create</p>
            </button>
        </a>
        <a href="{{ url('/profile') }}">
            <button>
                <i class="ri-user-line"></i>
                <p>Profile</p>
            </button>
        </a>
    </nav>
    <main>
        @php
            $cards = [
                ['username' => 'Username 1', 'title' => 'Judul 1', 'description' => 'Deskripsi pertama'],
                ['username' => 'Username 2', 'title' => 'Judul 2', 'description' => 'Deskripsi kedua'],
                ['username' => 'Username 3', 'title' => 'Judul 3', 'description' => 'Deskripsi ketiga'],
                ['username' => 'Username 4', 'title' => 'Judul 4', 'description' => 'Deskripsi keempat'],
                ['username' => 'Username 5', 'title' => 'Judul 5', 'description' => 'Deskripsi kelima'],
                ['username' => 'Username 6', 'title' => 'Judul 6', 'description' => 'Deskripsi keenam'],
                ['username' => 'Username 7', 'title' => 'Judul 7', 'description' => 'Deskripsi ketujuh'],
                ['username' => 'Username 8', 'title' => 'Judul 8', 'description' => 'Deskripsi kedelapan'],
                ['username' => 'Username 9', 'title' => 'Judul 9', 'description' => 'Deskripsi kesembilan'],
                ['username' => 'Username 10', 'title' => 'Judul 10', 'description' => 'Deskripsi kesepuluh'],
            ];
        @endphp
        @foreach ($cards as $card)
            <x-content-card :username="$card['username']" :title="$card['title']" :description="$card['description']" />
        @endforeach
    </main>
</body>
</html>
