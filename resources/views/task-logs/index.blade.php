@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        @if (isset($data))
            <x-panel title="Lista de Tarefas">

                @include('layouts.partials.messages')

                <x-title>Último acionamento:</x-title>
                <x-note>
                    <span style="font-weight: 600;">Início:</span>
                    {{ $last_start ? \Carbon\Carbon::parse($last_start)->format('d/m/Y H:i:s') : '' }}
                    <br><span style="font-weight: 600;">Término:</span>
                    {{ $last_end ? \Carbon\Carbon::parse($last_end)->format('d/m/Y H:i:s') : '' }}
                </x-note>

                <table class="table table-bordered table-striped table-hover">

                    <thead>
                        <tr>
                            <th>Chave</th>
                            <th>Descrição</th>
                            <th width="120">Detalhes</th>
                            <th width="180">Início</th>
                            <th width="180">Fim</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data->get() as $row)
                            <tr>
                                <td>
                                    {{ $row->signature }}
                                </td>
                                <td>
                                    {{ $row->description }}
                                </td>
                                <td>
                                    {!! \App\Helpers\DataTableHelper::memo($row->details) !!}
                                </td>
                                <td>
                                    {{ $row->start_time ? \Carbon\Carbon::parse($row->start_time)->format('d/m/Y H:i:s') : '-' }}
                                </td>
                                <td>
                                    {{ $row->end_time ? \Carbon\Carbon::parse($row->end_time)->format('d/m/Y H:i:s') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Nenhum registro encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </x-panel>
        @else
            @include('layouts.partials.messages')
        @endif

        <x-panel title="Dados">
            @include('task-logs.components.datatable')
        </x-panel>
    </x-content>
@endsection
