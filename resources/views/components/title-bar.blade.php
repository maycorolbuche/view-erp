@if ($title != '' || $description != '')
    <div class="title-bar">
        @if ($title != '')
            <h1>{{ $title }}</h1>
        @endif
        @if ($description != '')
            <p>{{ $description }}</p>
        @endif
    </div>
@endif
