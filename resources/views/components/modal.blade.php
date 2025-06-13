@props(['id', 'title' => 'Modal Title'])

<div id="{{ $id }}" class="modal-overlay" style="display: none;">
    <div class="modal">
        <div class="modal-header">
            <h2>{{ $title }}</h2>
        </div>

        <div class="modal-body">
            {{ $slot }}
        </div>

        @isset($footer)
        <div class="modal-footer">
            {{ $footer }}
        </div>
        @endisset
    </div>
</div>
