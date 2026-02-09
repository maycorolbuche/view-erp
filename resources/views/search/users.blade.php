@extends('layouts.search')

@section('content')
    <x-content>

        <x-data-table data-origin="users.datatable" order="name"
            columns="{{ json_encode([
                [
                    'data' => 'search',
                    'width' => '20px',
                    'orderable' => false,
                ],
                [
                    'title' => 'Código',
                    'data' => 'id_user',
                    'className' => 'text-right',
                ],
                [
                    'title' => 'Nome',
                    'data' => 'name',
                ],
                [
                    'title' => 'E-mail',
                    'data' => 'email',
                ],
                [
                    'title' => 'Filial',
                    'data' => 'branch.name',
                ],
            ]) }}" />


    </x-content>
@endsection
