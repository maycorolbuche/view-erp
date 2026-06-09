@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário">

            @include('holidays.components.header', ['holiday' => isset($data) ? $data : null])

            @include('layouts.partials.messages')

            <x-form action-name="holidays" action-id="{{ isset($data) ? $data->id_holiday : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                    <x-input type="radio" name="type" width="400" label="Tipo"
                        list="{{ json_encode([['key' => 'unique', 'value' => 'Único'], ['key' => 'repeat', 'value' => 'Recorrente'], ['key' => 'easter', 'value' => 'Dinâmico']]) }}"
                        list-value="key" list-text="value" value="{{ $data->type ?? 'unique' }}"
                        tip="Único = Somente 1 vez / Recorrente = Anualmente / Dinâmico = Relativo a Páscoa" />
                    <x-input type="date" name="date" width="150" label="Data" required
                        value="{{ $data->date ?? '' }}" />
                    <x-input type="number" name="easter" width="150" label="Qtd. Dias ref. Páscoa" required
                        value="{{ $data->easter ?? '' }}" tip="Qtd. de dias referente ao feriado de páscoa" />
                </x-group>
                <x-group>
                    @php
                        $idBranchValues = [];
                        if (isset($data) && isset($data->holidays_branches)) {
                            foreach ($data->holidays_branches as $item) {
                                $idBranchValues[] = $item['id_branch'];
                            }
                        }
                    @endphp

                    <x-input type="checkbox" name="id_branch" width="200" label="Filiais"
                        list="{{ json_encode($branches) }}" list-value="id_branch" list-text="name"
                        value="{{ json_encode($idBranchValues ?? '[]') }}" tip="Se for feriado nacional, deixe em branco" />
                </x-group>

                <x-group right>
                    <x-button type="store" hidden="{{ isset($data) }}"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="store-new" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="update" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="delete" hidden="{{ !isset($data) }}" disabled="{{ isset($data) && $data->root }}"
                        permission="{{ in_array('destroy', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="holidays" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados">
            @include('holidays.components.datatable', ['route' => 'holidays.show'])
        </x-panel>
    </x-content>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const typeInputs = document.querySelectorAll('[name="type"]');

            typeInputs.forEach(input => {
                input.addEventListener('change', changeType);
            });

            changeType();
        });

        function changeType() {
            const checked = document.querySelector('[name="type"]:checked');
            const val = checked?.value;

            const groupEaster = document.getElementById('group-easter');
            const groupDate = document.getElementById('group-date');
            const date = document.getElementById('date');

            groupEaster.style.display = 'none';
            groupDate.style.display = '';

            date.removeAttribute('min');
            date.removeAttribute('max');

            if (val === 'repeat') {
                date.setAttribute('min', '{{ date('Y') }}-01-01');
                date.setAttribute('max', '{{ date('Y') }}-12-31');
            } else if (val === 'easter') {
                groupDate.style.display = 'none';
                groupEaster.style.display = '';
            }

            console.log('XXX', val);
        }
    </script>
@endpush
