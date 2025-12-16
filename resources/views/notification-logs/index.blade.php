@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        @if (isset($data))
            <x-panel title="Dados do E-mail" type="primary">

                @include('layouts.partials.messages')

                <x-title>{{ $data->subject }}
                    <span style="float: right;">
                        {!! $data->status == 'sent' ? "<span class='badge badge-success'>Enviado</span>" : $data->status !!}
                    </span>
                </x-title>
                <x-note>
                    <span style="font-weight: 600;">Para:</span> <a
                        href="mailto:{{ $data->recipient }}">{{ $data->recipient }}</a>
                    <br><span style="font-weight: 600;">Data/Hora:</span>
                    {{ \Carbon\Carbon::parse($data->sent_at)->format('d/m/Y H:i:s') }}
                </x-note>

                {!! $data->message !!}

                <br>

                <x-group right>
                    <x-button type="cancel" route-name="notification-logs" />
                </x-group>
            </x-panel>
        @else
            @include('layouts.partials.messages')
        @endif

        <x-panel title="Dados" type="warning">
            @include('notification-logs.components.datatable', ['route' => 'notification-logs.show'])
        </x-panel>
    </x-content>
@endsection
