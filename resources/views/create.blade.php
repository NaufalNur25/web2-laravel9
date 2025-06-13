<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Music</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
    <nav>
        <a href="{{ url('/home') }}">
            <button>
                <i class="ri-home-line"></i>
                <p>Home</p>
            </button>
        </a>
        <a href="{{ url('/create') }}">
            <button>
                <i class="ri-add-box-fill"></i>
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
        <form action="">
            <section>
                <label for="description">Description:</label>
                <textarea name="description" id="description" cols="30" rows="5"></textarea>
            </section>

            <section class="switch-wrapper">
                <label for="is_public">Public</label>
                <label class="switch">
                    <input type="checkbox" name="aktif" id="is_public" value="1" {{ old('aktif', $default ?? false) ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
                <p>
                    <span>* </span>
                    When enabled, your post will be publicly visible to other users.
                </p>
            </section>

            <section class="dropdown-input-wrapper">
                <label for="kategori-input">Music</label>
                <div class="dropdown-input-container">
                    <input type="text" name="kategori" id="kategori-input" class="dropdown-input"
                        placeholder="--- Type the title of the music ---" autocomplete="off"
                        onfocus="showDropdown()" oninput="filterDropdown()">
                    <i class="ri-arrow-down-s-line dropdown-arrow"></i>
                </div>


                <ul class="dropdown-options" id="kategori-options">
                    <li onclick="selectOption('Musik')">Musik</li>
                    <li onclick="selectOption('Film')">Film</li>
                    <li onclick="selectOption('Buku')">Buku</li>
                    <li onclick="selectOption('Podcast')">Podcast</li>
                    <li class="not-found" style="display: none; color: #888; cursor: default; pointer-events: none; padding: 8px 12px;">
                        Tidak ditemukan
                    </li>
                </ul>

                <p>
                    <span>* </span>
                    Describe your current mood or feelings in the description. We'll recommend the top 10 songs that best match the words you write.
                </p>
            </section>

            <button type="submit" style="margin-top: 20px;">Post</button>
        </form>
    </main>

    <script>
        const input = document.getElementById('kategori-input');
        const dropdown = document.getElementById('kategori-options');

        function showDropdown() {
            dropdown.style.display = 'block';
        }

        function selectOption(value) {
            input.value = value;
            dropdown.style.display = 'none';
        }

        function filterDropdown() {
            const filter = input.value.toLowerCase();
            const options = dropdown.querySelectorAll('li:not(.not-found)');
            let anyVisible = false;

            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                const match = text.includes(filter);
                option.style.display = match ? 'block' : 'none';
                if (match) anyVisible = true;
            });

            const notFound = dropdown.querySelector('.not-found');
            notFound.style.display = anyVisible ? 'none' : 'block';
        }

        document.addEventListener('click', function (e) {
            if (!input.parentNode.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
</body>
</html>
