@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        @include('layouts.partials.messages')

        <x-panel title="Registro de Transações" type="warning">

            <x-data-table data-origin="cash-flow.datatable" order="created_at" order_dir="desc"
                columns="{{ json_encode([
                    [
                        'title' => 'Código',
                        'data' => 'id_transaction',
                        'className' => 'text-right',
                    ],
                    [
                        'title' => 'Data',
                        'data' => 'created_at',
                        'className' => 'text-center',
                    ],
                    [
                        'title' => 'Descrição',
                        'data' => 'description',
                    ],
                    [
                        'title' => 'Valor',
                        'data' => 'amount',
                        'className' => 'text-right',
                    ],
                ]) }}" />
        </x-panel>
    </x-content>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#bt_add_payment").click(function() {
                $("#transaction").val("add");
                return true;
            });
            $("#bt_remove_payment").click(function() {
                $("#transaction").val("remove");
                return true;
            });
        });
    </script>
@endpush
