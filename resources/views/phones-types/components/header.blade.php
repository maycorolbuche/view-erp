@if ($phone_type)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $phone_type->description ?? '' }}
        </small>
    </h1>
@endif
