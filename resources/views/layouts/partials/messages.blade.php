@php
    $messages = [];
    if (isset($errors) && count($errors) > 0) {
        $messages['danger'] = $errors->all();
    }

    if (Session::get('error', false)) {
        if (is_array(Session::get('error'))) {
            foreach (Session::get('error') as $msg) {
                $messages['danger'][] = $msg;
            }
        } else {
            $messages['danger'][] = Session::get('error');
        }
    }
    if (Session::get('success', false)) {
        if (is_array(Session::get('success'))) {
            foreach (Session::get('success') as $msg) {
                $messages['success'][] = $msg;
            }
        } else {
            $messages['success'][] = Session::get('success');
        }
    }
@endphp

@foreach ($messages as $type => $message)
    @if (count($message) > 0)
        <div class="alert alert-{{ $type }} alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            @if (count($message) == 1)
                <i class="fa fa-{{ $type == 'danger' ? 'remove' : 'check' }} pr10"></i>
                {!! $message[0] !!}
            @else
                <ul class="list-unstyled mb-0">
                    @foreach ($message as $msg)
                        <li><i class="fa fa-{{ $type == 'danger' ? 'remove' : 'check' }} pr10"></i>{{ $msg }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
@endforeach
