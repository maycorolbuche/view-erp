@if ($relationship_degree)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $relationship_degree->name ?? '' }}
        </small>
    </h1>
@endif
