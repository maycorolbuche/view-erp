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
        <div class="alert alert-{{ $type }} alert-dismissable mt-3 d-flex align-items-center" role="alert">
            @if ($type == 'danger')
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            @elseif ($type == 'success')
                <i class="bi bi-check-circle-fill fs-5"></i>
            @elseif ($type == 'info')
                <i class="bi bi-info-circle-fill fs-5"></i>
            @endif

            @if (count($message) == 1)
                <span class="flex-fill px-3">
                    {!! $message[0] !!}
                </span>
            @else
                <ul class="flex-fill mb-0">
                    @foreach ($message as $msg)
                        <li>{{ $msg }}</li>
                    @endforeach
                </ul>
            @endif

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endforeach
