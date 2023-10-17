@if (isset($errors) && count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul class="list-unstyled mb-0">
            @foreach ($errors->all() as $error)
                <li><i class="fa fa-remove pr10"></i>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-success" role="alert">
                <i class="fa fa-check pr10"></i>
                {{ $msg }}
            </div>
        @endforeach
    @else
        <div class="alert alert-success" role="alert">
            <i class="fa fa-check pr10"></i>
            {{ $data }}
        </div>
    @endif
@endif
