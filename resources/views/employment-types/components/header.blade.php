@if ($employment_type)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $employment_type->description ?? '' }}
        </small>
    </h1>
@endif
