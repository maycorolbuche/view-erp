<form role="form" method="{{ $method == 'put' ? 'post' : $method }}" action="{{ $action }}" novalidate="novalidate"
    class="validate" enctype="{{ $files ? 'multipart/form-data' : '' }}">
    {{ csrf_field() }}
    @method($method)
    <input type="hidden" name="_action">
    <input type="hidden" name="_id" value="{{ $actionId ?: '' }}">

    {{ $slot }}
</form>
