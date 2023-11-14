@if ($authorization_type)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $authorization_type->name ?? '' }}
        </small>
    </h1>
@endif
