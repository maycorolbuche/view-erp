@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('users.components.header', ['user' => isset($data) ? $data : null])

            @include('users.components.tabs', ['id' => isset($data) ? $data->id_user : null])

            @include('layouts.partials.messages')

            @if (isset($data) && $data->root == true)
                <blockquote class="blockquote-warning">
                    <p>Este usuário não pode ser apagado, pois é um usuário do sistema.</p>
                </blockquote>
            @endif

            <x-form action-name="users" action-id="{{ isset($data) ? $data->id_user : null }}">
                <x-group>
                    <x-input type="select" name="id_employment_type" width="200" label="Tipo de Recurso" required
                        list="{{ json_encode($employment_types) }}" list-value="id_employment_type" list-text="description"
                        value="{{ $data->id_employment_type ?? '' }}" />
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                    <x-input type="email" name="email" width="400" label="E-mail" required
                        value="{{ $data->email ?? '' }}" />
                    <x-input type="cpf_cnpj" name="cpf_or_cnpj" width="200" label="CPF/CNPJ"
                        value="{{ $data->cpf_or_cnpj ?? '' }}" />
                    <x-input type="text" name="id_card" width="200" label="RG"
                        value="{{ $data->id_card ?? '' }}" />
                    <x-input type="pis" name="pis" width="200" label="PIS/PASEB"
                        value="{{ $data->pis ?? '' }}" />
                    <x-input type="date" name="birth_date" width="200" label="Dt. Nascimento"
                        value="{{ $data->birth_date ?? '' }}" />
                    <x-input type="select" name="id_civil_status" width="200" label="Estado Civil"
                        list="{{ json_encode($civil_statuses) }}" list-value="id_civil_status" list-text="description"
                        value="{{ $data->id_civil_status ?? '' }}" />
                </x-group>
                <!--
                                echo titulo("Dados Pessoais",array("data-bloco"=>"dados"));
                                echo blocoInicio(array("data-bloco"=>"dados"));
                                echo input(array("type"=>"select","id"=>"ID_TIPO_RECURSO","label"=>"Tipo Recurso","value"=>@$post["ID_TIPO_RECURSO"],"items"=>listTiposRecurso(),"required"=>true,"width"=>100));
                                echo input(array("type"=>"text","id"=>"NOME","label"=>"Nome","value"=>@$post["NOME"],"required"=>true,"width"=>600,"autofocus"=>true));
                                echo input(array("type"=>"email","id"=>"EMAIL","label"=>"E-mail","value"=>@$post["EMAIL"],"width"=>400));
                                cpf_or_cnpj    echo input(array("type"=>"text","id"=>"CPFCNPJ","label"=>"CPF/CNPJ","value"=>@$post["CPFCNPJ"],"class"=>"cpfcnpj","width"=>200));
                                id_card    echo input(array("type"=>"text","id"=>"RG","label"=>"RG","value"=>@$post["RG"],"width"=>200));
                                pis    echo input(array("type"=>"text","id"=>"PIS","label"=>"PIS","value"=>@$post["PIS"],"width"=>150));
                                birth_date echo input(array("type"=>"date","id"=>"DT_NASC","label"=>"Dt. Nascimento","value"=>@$post["DT_NASC"],"width"=>150));
                               id_civil_status echo input(array("type"=>"select","id"=>"ID_ESTADO_CIVIL","label"=>"Estado Civil","items"=>listTiposEstCivil(),"value"=>@$post["ID_ESTADO_CIVIL"],"width"=>150));
                                echo blocoFim();

                                echo "<div class='d-none'>";
                                echo input(array("type"=>"html","id"=>"TELEFONE","label"=>"Telefones"));
                                echo "</div>";

                                echo "<div data-input-id='".cripto_inpt("TELEFONE")."'>";

                                echo titulo("Telefones",array("data-bloco"=>"tel"));
                                echo blocoInicio(array("id"=>"bloco_telefone","data-bloco"=>"tel"));
                                //echo input(array("type"=>"radio","ident"=>cripto_inpt("PRINCIPAL"),"label"=>"Principal?","items"=>array("S"=>""),"width"=>50));
                                echo input(array("type"=>"select","ident"=>cripto_inpt("ID_TIPO_TELEFONE"),"label"=>"Tipo","class"=>"nochosen","items"=>listTiposTelefones(),"width"=>100));
                                echo input(array("type"=>"text","ident"=>cripto_inpt("TELEFONE"),"label"=>"Telefone","class"=>"telefone","width"=>150));
                                echo input(array("type"=>"select","ident"=>cripto_inpt("ID_TIPO_OPERADORA"),"label"=>"Operadora","class"=>"nochosen","items"=>listOperadoras(),"width"=>100));
                                echo input(array("type"=>"text","ident"=>cripto_inpt("CONTATO"),"label"=>"Contato","width"=>150));
                                echo input(array("type"=>"text","ident"=>cripto_inpt("OBSERVACAO"),"label"=>"Obs.","width"=>150));
                                echo botoesInicio(array("class"=>"botao align-items-end"));
                                echo button(array("type"=>"a","href"=>"javascript:","onClick"=>"","layout"=>"remove","size"=>"sm","class"=>"badge badge-danger","style"=>"margin:0 !important;"));
                                echo botoesFim();
                                echo blocoFim();

                                echo "<div id='div_telefone'></div>";

                                echo botoesInicio();
                                echo button(array("action"=>"add_telefone","id"=>"bt_add_telefone","value"=>"Adicionar Telefone","onClick"=>"addTelefone();return false;","layout"=>"add"));
                                echo botoesFim();

                                echo "</div>";

                                echo titulo("Endere&ccedil;o",array("data-bloco"=>"endereco"));
                                echo blocoInicio(array("data-bloco"=>"endereco"));
                                echo "<script>
                                    cep_ant = \"".@$post["CEP"].
                                    "\";
                                </script>";
                                echo input(array("type"=>"text","id"=>"CEP","label"=>"CEP","value"=>@$post["CEP"],"width"=>100,"class"=>"cep","onFocus"=>"cep_ant=this.value;","onBlur"=>"buscaCEP(\"#".cripto_inpt("CEP")."\",\"#".cripto_inpt("ENDERECO")."\",\"#".cripto_inpt("NUMERO")."\",\"#".cripto_inpt("BAIRRO")."\",\"#".cripto_inpt("CIDADE")."\",\"#".cripto_inpt("ESTADO")."\",cep_ant)"));
                                echo input(array("type"=>"text","id"=>"ENDERECO","label"=>"Endere&ccedil;o","value"=>@$post["ENDERECO"],"width"=>600));
                                echo input(array("type"=>"number","id"=>"NUMERO","label"=>"N&ordm;","value"=>@$post["NUMERO"],"width"=>100));
                                echo input(array("type"=>"text","id"=>"COMPLEMENTO","label"=>"Complemento","value"=>@$post["COMPLEMENTO"],"width"=>200));
                                echo input(array("type"=>"text","id"=>"PONTO_REFERENCIA","label"=>"Ponto de Refer&ecirc;ncia","value"=>@$post["PONTO_REFERENCIA"],"width"=>250));
                                echo input(array("type"=>"text","id"=>"BAIRRO","label"=>"Bairro","value"=>@$post["BAIRRO"],"width"=>250));
                                echo input(array("type"=>"text","id"=>"CIDADE","label"=>"Cidade","value"=>@$post["CIDADE"],"width"=>250));
                                echo input(array("type"=>"text","id"=>"ESTADO","label"=>"Estado","class"=>"uf uppercase","value"=>@$post["ESTADO"],"width"=>100));
                                echo blocoFim();

                                echo titulo("Dados Adicionais",array("data-bloco"=>"bloco_dados_adic"));
                                echo blocoInicio(array("data-bloco"=>"bloco_dados_adic"));
                                echo input(array("type"=>"number","id"=>"ID_PESSOA_VAS","label"=>"C&oacute;d. VAS","value"=>@$post["ID_PESSOA_VAS"],"width"=>100));
                                echo input(array("type"=>"select","id"=>"ID_FILIAL","label"=>"Filial","value"=>@$post["ID_FILIAL"],"items"=>listFiliais(),"width"=>100));
                                echo input(array("type"=>"radio","id"=>"CAIXA_VIEW","label"=>"Caixa View?","value"=>@$post["CAIXA_VIEW"],"items"=>array("S"=>"Sim","N"=>"N&atilde;o"),"width"=>150));
                                echo blocoFim();
                                -->

                <x-group right>
                    <x-button type="store" hidden="{{ isset($data) }}"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="store-new" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="update" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="delete" hidden="{{ !isset($data) }}" disabled="{{ isset($data) && $data->root }}"
                        permission="{{ in_array('destroy', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="users" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('users.components.datatable', ['route' => 'users.show'])
        </x-panel>
    </x-content>
@endsection

@push('scripts')
    <script>
        $("[name=name]").blur(function() {
            if ($("[name=slug]").val() == "") {
                $("[name=slug]").val($("[name=name]").val()).blur()
            }
        });
    </script>
@endpush
