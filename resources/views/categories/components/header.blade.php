@if ($category)
    <h1 class="mtn">
        <small style="padding-left:10px;">
            {{ $category->name ?? '' }}
        </small>
    </h1>
@endif
