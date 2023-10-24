<form role="form" method="{{ $method }}" action="{{ $action }}" novalidate="novalidate" class="validate">
    {{ csrf_field() }}
    <input type="hidden" name="_action">

    {{ $slot }}
</form>
