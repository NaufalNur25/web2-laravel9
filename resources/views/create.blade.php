<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mood Music</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('css/create.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <nav>
        <a href="{{ url('/home') }}"><button><i class="ri-home-line"></i>
                <p>Home</p>
            </button></a>
        <a href="{{ url('/create') }}"><button><i class="ri-add-box-fill"></i>
                <p>Create</p>
            </button></a>
        <a href="{{ url('/profile') }}"><button><i class="ri-user-line"></i>
                <p>Profile</p>
            </button></a>
    </nav>

    <main>
        <form id="musicForm" action="{{ route('music.create') }}">
            <section>
                <label for="description">Description:</label>
                <textarea name="description" id="description" cols="30" rows="5" placeholder="Write something... maximum 250 characters" maxlength="250" required></textarea>
            </section>

            <section class="switch-wrapper">
                <label for="is_public">Public</label>
                <label class="switch">
                    <input type="checkbox" name="aktif" id="is_public" value="1" {{ old('aktif', $default ?? false) ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
                <p><span>* </span>When enabled, your post will be publicly visible to other users.</p>
            </section>

            <section class="dropdown-input-wrapper">
                <label for="kategori-input">Music</label>
                <div class="dropdown-input-container">
                    <input type="text" name="kategori" id="kategori-input" class="dropdown-input"
                        placeholder="--- Type the title of the music ---" autocomplete="off"
                        onfocus="showDropdown()" required />
                    <i class="ri-arrow-down-s-line dropdown-arrow"></i>
                </div>

                <ul class="dropdown-options" id="kategori-options">
                    <li class="loading"><i class="ri-loader-4-line ri-spin"></i> Loading...</li>
                    <li class="not-found" style="display: none; color: #888; pointer-events: none; padding: 8px 12px;">
                        Tidak ditemukan
                    </li>
                </ul>

                <div id="track-preview" class="track-preview" style="display:none;"></div>

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
        const textarea = document.getElementById('description');
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const wrapper = document.querySelector('.dropdown-input-wrapper');
        const trackPreview = document.getElementById('track-preview');

        let debounceTimeoutDesc, debounceTimeoutInput;
        let latestRecommendations = [];
        let latestSearchResults = [];
        let selectedTrack = null;

        function showDropdown() {
            const items = dropdown.querySelectorAll('li:not(.not-found):not(.loading)');
            if (items.length > 0) {
                dropdown.style.display = 'block';
            }
        }

        function hideDropdown() {
            dropdown.style.display = 'none';
        }

        function showLoading() {
            dropdown.querySelectorAll('li:not(.not-found):not(.loading)').forEach(li => li.remove());
            dropdown.querySelector('.loading').style.display = 'block';
            dropdown.querySelector('.not-found').style.display = 'none';
            dropdown.style.display = 'block';
        }

        function hideLoading() {
            dropdown.querySelector('.loading').style.display = 'none';
        }

        function updateDropdown(items = []) {
            const notFound = dropdown.querySelector('.not-found');
            hideLoading();
            dropdown.querySelectorAll('li:not(.not-found):not(.loading)').forEach(li => li.remove());

            if (Array.isArray(items) && items.length > 0) {
                items.slice(0, 10).forEach(track => {
                    const li = document.createElement('li');
                    const artistName = track.artists?.name || track.artist || '-';
                    li.innerHTML = `
                        <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="${track.albums?.image}" alt="album" width="32" height="32"></img><strong>${track.name}</strong> — ${artistName}
                        </div>
                        `;
                    li.onclick = () => selectOption(track);
                    dropdown.insertBefore(li, notFound);
                });
                notFound.style.display = 'none';
            } else {
                notFound.style.display = 'block';
            }

            dropdown.style.display = 'block';
        }

        function selectOption(track) {
            selectedTrack = track;
            input.value = track.name;
            showTrackPreview(track);
            hideDropdown();
        }

        function showTrackPreview(track) {
            if (!track) {
                trackPreview.style.display = 'none';
                return;
            }

            const artist = track.artists?.name || track.artist || '-';
            const image = track.albums?.image || track.album?.image || '';

            trackPreview.innerHTML = `
                <img src="${image}" alt="Album Cover">
                <div>
                    <div><strong>${track.name}</strong></div>
                    <div style="font-size: 14px; color: #555;">${artist}</div>
                </div>
                `;
            trackPreview.style.display = 'flex';
        }

        function toggleDropdownEnabled() {
            if (textarea.value.trim().length === 0) {
                wrapper.classList.add('disabled');
                input.disabled = true;
            } else {
                wrapper.classList.remove('disabled');
                input.disabled = false;
            }
        }

        document.addEventListener('click', function(e) {
            if (!input.parentNode.contains(e.target)) {
                hideDropdown();
            }
        });

        input.addEventListener('focus', showDropdown);

        input.addEventListener('input', () => {
            clearTimeout(debounceTimeoutInput);
            debounceTimeoutInput = setTimeout(() => {
                const keyword = input.value.trim();
                if (keyword.length === 0) {
                    updateDropdown([]);
                    return;
                }

                showLoading();

                fetch(`{{ route('spotify.tracks.dropdown') }}?name=${encodeURIComponent(keyword)}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        latestSearchResults = data;
                        updateDropdown(data);
                    })
                    .catch(error => {
                        console.error('❌ Error fetching dropdown tracks:', error);
                        updateDropdown([]);
                    });
            }, 500);
        });

        textarea.addEventListener('input', () => {
            clearTimeout(debounceTimeoutDesc);
            toggleDropdownEnabled();

            const text = textarea.value.trim();

            if (text.length === 0) {
                updateDropdown([]);
                selectedTrack = null;
                input.value = "";
                showTrackPreview(null);
                return;
            }

            debounceTimeoutDesc = setTimeout(() => {
                showLoading();

                fetch("{{ route('spotify.recommendations') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": token,
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            text: text
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        latestRecommendations = data;
                        if (input.value.trim() === '') {
                            updateDropdown(data);
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error fetching recommendations:', error);
                        updateDropdown([]);
                    });
            }, 1000);
        });

        document.addEventListener('DOMContentLoaded', () => {
            toggleDropdownEnabled();
        });

        document.getElementById('musicForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const desc = textarea.value.trim();
            const isPublic = document.getElementById('is_public').checked;

            if (!desc) {
                alert('Deskripsi wajib diisi.');
                return;
            }

            if (!selectedTrack?.id) {
                alert('Silakan pilih lagu dari dropdown terlebih dahulu.');
                return;
            }

            const data = {
                content: desc,
                visibility: isPublic,
                spotify_id: selectedTrack.id,
                expires_at: '2026-12-31',
            };

            fetch('{{ route("music.create") }}', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify(data),
            })
            .then(response => {
                if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(result => {
                alert('Berhasil diposting!');
                window.location.href = '/profile';
            })
            .catch(error => {
                console.error('❌ Gagal post:', error);
                alert('Gagal mengirim data. Cek console.');
            });
        });
    </script>
</body>

</html>
