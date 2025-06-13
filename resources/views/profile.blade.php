<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Music</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/content-card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/modal.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.style.display = 'none';
        }
    });
</script>
<body>
    <nav>
        <a href="{{ url('/home') }}">
            <button>
                <i class="fa-solid fa-house"></i>
                <p>Home</p>
            </button>
        </a>
        <a href="{{ url('/create') }}">
            <button>
                <i class="fa-regular fa-square-plus"></i>
                <p>Create</p>
            </button>
        </a>
        <a href="{{ url('/profile') }}">
            <button>
                <i class="fa-regular fa-user"></i>
                <p>Profile</p>
            </button>
        </a>
    </nav>
    <main>
        <div class="user-profile">
            <p class="username">{{ "@" . Auth::user()->username }}</p>
            <p class="post">1 Post</p>
            <button onclick="openModal('modal-confirm')">
                <i class="fa-solid fa-gear"></i>
            </button>
        </div>
        <div class="posted">
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
        </div>
    </main>

    <x-modal id="modal-confirm" title="Settings">
        <div class="modal-action">
            <button class="button-modal">Log Out</button>
            <button class="button-modal" onclick="closeModal('modal-confirm')">Cancel</button>
        </div>
    </x-modal>
</body>
</html>
