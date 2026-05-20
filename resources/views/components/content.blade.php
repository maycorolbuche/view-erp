@if ($title != '' || $description != '')
    <x-title-bar :title="$title" :description="$description" />
@endif
<div class="d-flex flex-column gap-4">
    {{ $slot }}
</div>
