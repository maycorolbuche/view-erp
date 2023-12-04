@extends('layouts.app')
@section('title', 'Autorização de Despesas')
@section('breadcrumb', json_encode([['label' => 'Autorização de Despesas', 'icon' => 'fas fa-check-double']]))

@section('content')
    <x-content>

        @if (isset($data))

            @php
                $type = 'muted';
                $status = 'Expirado';
                if ($data->approved === 1) {
                    $type = 'success';
                    $status = 'Aprovado';
                } elseif ($data->approved === 0) {
                    $type = 'danger';
                    $status = 'Negado';
                } elseif ($data->active === 1) {
                    $type = 'warning';
                    $status = 'Pendente';
                }
            @endphp

            <x-panel title="Detalhes da Autorização | {{ $status }}" type="{{ $type }}">

                @include('layouts.partials.messages')

                <x-form action-name="me-authorizations" action-id="{{ isset($data) ? $data->id_authorization : null }}">

                    <span class='badge badge-success'>{{ $data->authorization_type->name }}</span>
                    <span class='badge badge-{{ $type }}'>{{ $status }}</span>
                    <h1 class="mtn" style="margin:0;margin-top:10px;">
                        <small>
                            {{ $data->user->name ?? '' }}
                        </small>
                    </h1>

                    <h2 style="margin:0">
                        <small>
                            @if ($data->authorization_type->type == 'expense')
                                {{ $data->start_date_br }} a {{ $data->end_date_br }}
                            @elseif ($data->authorization_type->type == 'cash-advance')
                                {{ $data->start_date_br }}
                                <br>Valor: R$ {{ number_format($data->amount, 2, ',', '.') }}
                                <br>Autorização vinculada: {{ $data->authorization_parent->description_details }}
                            @endif
                        </small>
                    </h2>

                    <br>

                    @if (trim($data->description) != '')
                        <x-note>
                            {{ $data->description }}
                        </x-note>
                    @endif

                    @if ($data->authorization_type->type == 'expense')
                        <div class="panel-heading">
                            <span class="panel-title">
                                <span>Clientes</span>
                            </span>
                        </div>

                        <div class="panel-body pn">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                        @foreach ($data->clients as $client)
                                            <tr>
                                                <td>{{ $client->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <br>

                    <div class="panel-heading">
                        <span class="panel-title">
                            <span>Autorizações</span>
                        </span>
                    </div>
                    <div class="panel-body pn">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Status</th>
                                        <th>Motivo (caso recusado)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->statuses as $user)
                                        @php
                                            $user_type = 'muted';
                                            $user_status = 'Não informado';
                                            if ($user->pivot->approved === 1) {
                                                $user_type = 'success';
                                                $user_status = 'Aprovado';
                                            } elseif ($user->pivot->approved === 0) {
                                                $user_type = 'danger';
                                                $user_status = 'Negado';
                                            } elseif ($data->approved === null && $data->active === 1) {
                                                $user_type = 'warning';
                                                $user_status = 'Pendente';
                                            }
                                        @endphp
                                        <tr class="{{ $user_type }}">
                                            <td>{{ $user->short_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user_status }}</td>
                                            <td>{{ $user->pivot->description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($edit)
                        <hr>
                        <x-group>
                            <x-input type="radio" name="status" width="200" label="Resposta"
                                list="{{ json_encode([['status' => 'S', 'description' => 'Aprovar'], ['status' => 'N', 'description' => 'Negar']]) }}"
                                list-value="status" list-text="description" required />
                        </x-group>
                        <x-group>
                            <x-input type="textarea" name="description" label="Motivo da Recusa" required />
                        </x-group>
                    @endif

                    <br>

                    <x-group right>
                        @if ($edit)
                            <x-button type="update" />
                        @endif
                        <x-button type="cancel" route-name="me-authorizations" />
                    </x-group>

                </x-form>
            </x-panel>
        @endif

        @if (isset($pending))
            @if (count($pending) > 0)
                <x-panel title="Autorizações Pendentes" type="warning">
                    @foreach ($pending as $authorization)
                        <x-note type="warning">
                            <span class='badge badge-success'>{{ $authorization->authorization_type->name }}</span>
                            <b>{{ $authorization->user->name }}</b>
                            @if ($authorization->authorization_type->type == 'expense')
                                <br>{{ $authorization->start_date_br }} a {{ $authorization->end_date_br }}
                            @elseif ($authorization->authorization_type->type == 'cash-advance')
                                <br>{{ $authorization->start_date_br }}
                                <br>Valor: <b>R$ {{ number_format($authorization->amount, 2, ',', '.') }}</b>
                            @endif
                            <br>{{ $authorization->description }}
                            @if ($authorization->authorization_type->type == 'expense')
                                <br><b>Clientes:</b>
                                @foreach ($authorization->clients as $client)
                                    <span class='badge badge-info'>{{ $client->name }}</span>
                                @endforeach
                            @endif
                            <x-group right>
                                <a href="{{ route('me-authorizations.show', ['id' => $authorization->id_authorization]) }}"
                                    class="btn btn-warning">Visualizar</a>
                            </x-group>
                        </x-note>
                        <hr style="margin: 0 0 10px 0;">
                    @endforeach
                </x-panel>
            @endif
        @endif

        <x-panel title="Dados" type="warning">
            @include('me.authorizations.components.datatable', ['route' => 'me-authorizations.show'])
        </x-panel>
    </x-content>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $("[name=status]").change(function() {
                status_authorization();
            });
            status_authorization();

        });

        function status_authorization() {
            let val = $("[name=status]:checked").val();
            if (val == "N") {
                $("#group-description").show();
            } else {
                $("#group-description").hide();
            }
        }
    </script>
@endpush
