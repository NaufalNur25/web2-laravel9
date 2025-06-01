@extends('layouts.app')

@section('title', 'Send The Song')

@section('content')
    <style>
        /* Basic Reset & Body Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif; /* Changed to Inter font */
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Container Styling */
        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        /* Header Styling */
        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: #333;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        /* Form Group Styling */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 15px 18px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fff;
            outline: none;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .form-control:hover {
            border-color: #b0b7e8;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }

        /* Combobox Specific Styling */
        .combobox-container {
            position: relative;
        }

        .combobox-input {
            padding-right: 50px !important;
        }

        .combobox-arrow {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            padding: 5px;
            z-index: 2;
        }

        .combobox-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 2px solid #e1e5e9;
            border-top: 1px solid #e1e5e9;
            border-radius: 0 0 12px 12px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .combobox-dropdown.show {
            display: block;
        }

        .dropdown-arrow {
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid #666;
            transition: transform 0.3s ease;
        }

        .dropdown-item {
            padding: 12px 18px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item.highlighted {
            background-color: #f0f4ff;
            color: #667eea;
        }

        .dropdown-loading,
        .dropdown-empty,
        .dropdown-error {
            padding: 15px;
            text-align: center;
            font-size: 0.9rem;
        }

        .dropdown-error {
            color: #dc3545;
            font-style: italic;
        }

        /* Submit Button Styling */
        .submit-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 30px 25px;
                margin: 10px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .header p {
                font-size: 1rem;
            }
        }

        /* Icon Styling */
        .music-icon {
            display: inline-block;
            margin-right: 10px;
            font-size: 1.5rem;
        }

        /* Alert Messages */
        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        /* Custom Message Box Styling */
        .message-box-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .message-box-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .message-box {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .message-box-overlay.show .message-box {
            transform: scale(1);
        }

        .message-box h3 {
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .message-box p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .message-box button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .message-box button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }
    </style>

    <div class="container">
        <div class="header">
            <h1><span class="music-icon">🎵</span>Send The Song</h1>
            <p>Share your favorite music with someone special</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('song.submit') }}" method="POST" id="sendSongForm">
            @csrf

            <div class="form-group">
                <label for="recipient" class="form-label">Recipient</label>
                <input type="text" id="recipient" name="recipient" class="form-control"
                    placeholder="Enter recipient's name or email" value="{{ old('recipient') }}" required>
            </div>

            <div class="form-group">
                <label for="message" class="form-label">Message</label>
                <textarea id="message" name="message" class="form-control" placeholder="Write a personal message..." rows="4"
                    required>{{ old('message') }}</textarea>
            </div>

            <div class="form-group">
                <label for="song" class="form-label">Song</label>
                <div class="combobox-container">
                    <input type="text" id="songCombobox" class="form-control combobox-input"
                        placeholder="Type to search songs..." value="{{ old('song') }}" autocomplete="off" required
                        role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="songDropdown">
                    {{-- Hidden input to store the song ID --}}
                    <input type="hidden" id="songId" name="song" value="{{ old('song_id') }}">
                    <div class="combobox-arrow" id="comboboxArrow">
                        <div class="dropdown-arrow"></div>
                    </div>
                    <div class="combobox-dropdown" id="songDropdown">
                        <div class="dropdown-loading" id="dropdownLoading" style="display: none;">
                            <div style="padding: 15px; text-align: center; color: #667eea;">
                                🎵 Loading songs...
                            </div>
                        </div>
                        <div class="dropdown-empty" id="dropdownEmpty" style="display: none;">
                            <div style="padding: 15px; text-align: center; color: #999; font-style: italic;">
                                Type to search for songs
                            </div>
                        </div>
                        <div class="dropdown-error" id="dropdownError" style="display: none;">
                            <div style="padding: 15px; text-align: center; color: #dc3545; font-style: italic;">
                                Something went wrong. Please try again.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                Send The Song 🎶
            </button>
        </form>
    </div>

    <div class="message-box-overlay" id="messageBoxOverlay">
        <div class="message-box">
            <h3 id="messageBoxTitle"></h3>
            <p id="messageBoxContent"></p>
            <button id="messageBoxCloseBtn">OK</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const comboboxInput = document.getElementById('songCombobox');
            const songIdInput = document.getElementById('songId'); // New: Reference to hidden input
            const comboboxArrow = document.getElementById('comboboxArrow');
            const songDropdown = document.getElementById('songDropdown');
            const dropdownLoading = document.getElementById('dropdownLoading');
            const dropdownEmpty = document.getElementById('dropdownEmpty');
            const dropdownError = document.getElementById('dropdownError');
            const form = document.getElementById('sendSongForm');
            const messageBoxOverlay = document.getElementById('messageBoxOverlay');
            const messageBoxTitle = document.getElementById('messageBoxTitle');
            const messageBoxContent = document.getElementById('messageBoxContent');
            const messageBoxCloseBtn = document.getElementById('messageBoxCloseBtn');

            let isDropdownOpen = false;
            let currentHighlight = -1;
            let debounceTimer;

            // Function to show custom message box
            function showMessageBox(title, message) {
                messageBoxTitle.textContent = title;
                messageBoxContent.textContent = message;
                messageBoxOverlay.classList.add('show');
            }

            // Function to hide custom message box
            function hideMessageBox() {
                messageBoxOverlay.classList.remove('show');
            }

            // Event listener for message box close button
            messageBoxCloseBtn.addEventListener('click', hideMessageBox);

            // Function to toggle dropdown visibility
            function toggleDropdown(show) {
                isDropdownOpen = typeof show === 'boolean' ? show : !isDropdownOpen;
                songDropdown.classList.toggle('show', isDropdownOpen);
                comboboxInput.setAttribute('aria-expanded', isDropdownOpen);
                comboboxArrow.querySelector('.dropdown-arrow').style.transform = isDropdownOpen ? 'rotate(180deg)' : 'rotate(0deg)';

                if (!isDropdownOpen) {
                    currentHighlight = -1;
                    // Remove highlighted class from all items when closing
                    Array.from(songDropdown.children).forEach(item => {
                        item.classList.remove('highlighted');
                        item.setAttribute('aria-selected', 'false');
                    });
                }
            }

            // Function to fetch songs from API
            async function fetchSongs(query) {
                songDropdown.innerHTML = ''; // Clear previous results
                dropdownEmpty.style.display = 'none';
                dropdownError.style.display = 'none';

                if (query.length < 2) {
                    toggleDropdown(false); // Hide dropdown if query is too short
                    dropdownEmpty.style.display = 'block'; // Show "Type to search" message
                    return;
                }

                dropdownLoading.style.display = 'block'; // Show loading indicator
                toggleDropdown(true); // Ensure dropdown is open when loading

                try {
                    const response = await fetch(`/api/public/v1/spotify/tracks/dropdown?name=${encodeURIComponent(query)}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const data = await response.json();

                    dropdownLoading.style.display = 'none'; // Hide loading indicator

                    if (data.length === 0) {
                        dropdownEmpty.style.display = 'block'; // Show "No songs found"
                        dropdownEmpty.querySelector('div').textContent = 'No songs found. Type your own!';
                    } else {
                        data.forEach((song, index) => {
                            const item = document.createElement('div');
                            item.className = 'dropdown-item';
                            item.setAttribute('data-name', song.name); // Store song name
                            item.setAttribute('data-id', song.id);   // Store song ID
                            item.setAttribute('role', 'option');
                            item.setAttribute('id', `song-option-${index}`); // Unique ID for ARIA
                            item.textContent = song.name;
                            item.addEventListener('click', () => {
                                selectSong(song.name, song.id); // Pass both name and ID
                            });
                            songDropdown.appendChild(item);
                        });
                    }
                } catch (err) {
                    console.error('Error fetching songs:', err);
                    dropdownLoading.style.display = 'none'; // Hide loading
                    dropdownError.style.display = 'block'; // Show error message
                    toggleDropdown(true); // Keep dropdown open to show error
                }
            }

            // Debounce function
            function debounce(func, delay) {
                return function(...args) {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => func.apply(this, args), delay);
                };
            }

            const debouncedFetchSongs = debounce(fetchSongs, 300); // Debounce API calls by 300ms

            // Function to update highlighted item in dropdown
            function updateHighlight(direction) {
                const visibleItems = Array.from(songDropdown.children).filter(item =>
                    item.classList.contains('dropdown-item') && item.style.display !== 'none'
                );

                if (visibleItems.length === 0) {
                    currentHighlight = -1;
                    return;
                }

                // Remove highlight from previous item
                if (currentHighlight !== -1 && visibleItems[currentHighlight]) {
                    visibleItems[currentHighlight].classList.remove('highlighted');
                    visibleItems[currentHighlight].setAttribute('aria-selected', 'false');
                }

                if (direction === 'down') {
                    currentHighlight = (currentHighlight + 1) % visibleItems.length;
                } else if (direction === 'up') {
                    currentHighlight = currentHighlight <= 0 ? visibleItems.length - 1 : currentHighlight - 1;
                }

                // Add highlight to new item
                if (currentHighlight >= 0 && visibleItems[currentHighlight]) {
                    visibleItems[currentHighlight].classList.add('highlighted');
                    visibleItems[currentHighlight].setAttribute('aria-selected', 'true');
                    comboboxInput.setAttribute('aria-activedescendant', visibleItems[currentHighlight].id);
                    // Scroll into view if necessary
                    visibleItems[currentHighlight].scrollIntoView({ block: 'nearest' });
                } else {
                    comboboxInput.removeAttribute('aria-activedescendant');
                }
            }

            // Function to select a song from dropdown
            function selectSong(songName, songId) { // Now accepts both name and ID
                comboboxInput.value = songName;
                songIdInput.value = songId; // Set the hidden input's value to the song ID
                toggleDropdown(false); // Hide dropdown
                comboboxInput.focus(); // Return focus to input
            }

            // Event Listeners
            comboboxArrow.addEventListener('click', () => {
                toggleDropdown();
                if (isDropdownOpen && comboboxInput.value.trim().length >= 2) {
                    fetchSongs(comboboxInput.value.trim()); // Re-fetch or show existing if already typed
                } else if (isDropdownOpen) {
                    songDropdown.innerHTML = ''; // Clear previous items if any
                    dropdownEmpty.style.display = 'block'; // Show "Type to search" if dropdown opened with empty input
                }
            });

            comboboxInput.addEventListener('focus', () => {
                comboboxInput.parentElement.style.transform = 'scale(1.02)';
                if (comboboxInput.value.trim().length >= 2) {
                    debouncedFetchSongs(comboboxInput.value.trim());
                } else {
                    songDropdown.innerHTML = '';
                    dropdownEmpty.style.display = 'block';
                    toggleDropdown(true);
                }
            });

            comboboxInput.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
                // Delay hiding dropdown to allow click on items
                setTimeout(() => {
                    if (!songDropdown.contains(document.activeElement)) {
                        toggleDropdown(false);
                    }
                }, 100);
            });

            comboboxInput.addEventListener('input', function() {
                const query = this.value.trim();
                // Clear the hidden song ID if the user starts typing again
                songIdInput.value = '';
                if (query.length === 0) {
                    songDropdown.innerHTML = '';
                    dropdownEmpty.style.display = 'block';
                    dropdownError.style.display = 'none';
                    dropdownLoading.style.display = 'none';
                    toggleDropdown(true); // Keep dropdown open to show "Type to search"
                } else {
                    debouncedFetchSongs(query);
                }
                currentHighlight = -1; // Reset highlight on input change
            });

            comboboxInput.addEventListener('keydown', function(e) {
                if (!isDropdownOpen) return;

                switch (e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        updateHighlight('down');
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        updateHighlight('up');
                        break;
                    case 'Enter':
                        e.preventDefault();
                        const highlightedItem = songDropdown.querySelector('.highlighted');
                        if (highlightedItem) {
                            selectSong(highlightedItem.getAttribute('data-name'), highlightedItem.getAttribute('data-id'));
                        } else if (comboboxInput.value.trim() !== '') {
                            // If user types a song and presses Enter without selecting from dropdown,
                            // we still need to ensure songId is set if it was previously selected.
                            // For new, non-selected entries, songId will remain empty.
                            toggleDropdown(false);
                        }
                        break;
                    case 'Escape':
                        toggleDropdown(false);
                        break;
                }
            });

            // Close dropdown if clicked outside
            document.addEventListener('click', function(e) {
                if (!comboboxInput.contains(e.target) && !comboboxArrow.contains(e.target) && !songDropdown.contains(e.target)) {
                    toggleDropdown(false);
                }
            });

            // Form submission handling
            form.addEventListener('submit', function(e) {
                const recipient = document.getElementById('recipient').value.trim();
                const message = document.getElementById('message').value.trim();
                const songName = comboboxInput.value.trim(); // The displayed song name
                const songId = songIdInput.value.trim(); // The hidden song ID

                console.log(songId);


                // Validate that both song name and song ID are present if a selection was made
                // or if the user typed a song name and expects it to be submitted.
                // If a song name is present but no ID, it implies the user typed it manually
                // or it's a new entry not found in the dropdown.
                if (!recipient || !message || !songName) {
                    e.preventDefault(); // Prevent default form submission
                    showMessageBox('Validation Error', 'Please fill in all required fields (Recipient, Message, and Song).');
                    return false;
                }

                // If a song name is entered but no ID is selected, you might want to handle this
                // on the backend or prompt the user. For now, we'll allow submission with just the name
                // if no ID was selected, assuming the backend can handle it or that the ID is optional
                // if the user manually types. If song ID is strictly required, add `!songId` to the validation above.

                const submitBtn = form.querySelector('.submit-btn');
                submitBtn.textContent = 'Sending... 🎵';
                submitBtn.disabled = true;
            });

            // Input focus/blur animations
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
@endsection
