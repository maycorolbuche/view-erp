<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Helpers\ExpenseHelper;
use App\Helpers\RootHelper as Root;

class __DBMigrationSeeder extends Seeder
{
    public function run()
    {
        $batchSize = 500;

        config([
            'database.connections.mysql_old' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST_OLD'),
                'port' => 3306,
                'database' => env('DB_DATABASE_OLD'),
                'username' => env('DB_USERNAME_OLD'),
                'password' => env('DB_PASSWORD_OLD'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=0');


        $table = 'branches';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('FILIAL')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_branch' => $row->ID_FILIAL,
                    'name' => $row->NOME,
                    'short_name' => $row->SIGLA,
                    'zip_code' => $row->CEP,
                    'address' => $row->ENDERECO,
                    'number' => $row->NUMERO,
                    'complement' => $row->COMPLEMENTO,
                    'district' => $row->BAIRRO,
                    'city' => $row->CIDADE,
                    'state' => $row->ESTADO,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'users';
        $this->command->warn("Deletando $table");
        DB::table($table)->where('id_user', '>', 1)->delete();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('PESSOAS')
            ->select('PESSOAS.*', 'USUARIOS.LOGIN', 'USUARIOS.QTD_ACESSOS', 'TIPOS_ESTADO_CIVIL.ORDEM AS ID_ESTADO_CIVIL2')
            ->leftJoin('USUARIOS', 'PESSOAS.ID_PESSOA', '=', 'USUARIOS.ID_PESSOA')
            ->leftJoin('TIPOS_ESTADO_CIVIL', 'TIPOS_ESTADO_CIVIL.ID_ESTADO_CIVIL', '=', 'PESSOAS.ID_ESTADO_CIVIL')
            ->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                if ($row->ID_PESSOA > 1 && $row->ID_PESSOA <> 65) {
                    $batchData[] = [
                        'id_user' => $row->ID_PESSOA,
                        'name' => $row->NOME,
                        'username' => $row->LOGIN ?? Str::slug($row->NOME),
                        'email' => ($row->ID_PESSOA == 55
                            ? 'view_sp@viewfs.com.br'
                            : ($row->ID_PESSOA == 56
                                ? 'view_tatui@viewfs.com.br'
                                : ($row->ID_PESSOA == 57
                                    ? 'view_curitiba@viewfs.com.br'
                                    : str_replace('@viewinformatica.com.br', '@viewfs.com.br', $row->EMAIL)
                                )
                            )
                        ),
                        'cpf_or_cnpj' => $row->CPFCNPJ,
                        'id_card' => $row->RG,
                        'pis' => $row->PIS,
                        'birth_date' => $row->DT_NASC,
                        'id_civil_status' => $row->ID_ESTADO_CIVIL2,
                        'zip_code' => $row->CEP,
                        'address' => $row->ENDERECO,
                        'number' => $row->NUMERO,
                        'complement' => $row->COMPLEMENTO,
                        'district' => $row->BAIRRO,
                        'city' => $row->CIDADE,
                        'state' => $row->ESTADO,
                        'id_branch' => $row->ID_FILIAL,
                        'count_access' => $row->QTD_ACESSOS,
                        'id_employment_type' => ($row->ID_TIPO_RECURSO == 'J'
                            ? 2
                            : ($row->ID_TIPO_RECURSO == 'F'
                                ? 1
                                : ($row->ID_TIPO_RECURSO == 'S'
                                    ? 3
                                    : null
                                )
                            )
                        ),
                        'created_at' => $row->DATAHORA_CAD,
                        'updated_at' => $row->DATAHORA_ALT,
                    ];
                }
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'categories';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('TIPOS_DESPESA')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_category' => $row->ID_TIPO_DESPESA,
                    'id_category_type' => 1,
                    'name' => $row->NOME,
                    'short_name' => $row->NOME_RESUMO,
                    'created_by' => $row->ID_PESSOA_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_PESSOA_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'discounts';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('DESCONTOS')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_discount' => $row->ID_DESCONTO,
                    'name' => $row->DESCRICAO,
                    'created_by' => $row->ID_PESSOA_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_PESSOA_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'discounts_categories';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('DESCONTOS_TIPOS_DESPESAS')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_discount' => $row->ID_DESCONTO,
                    'id_category' => $row->ID_TIPO_DESPESA,
                    'created_by' => $row->ID_PESSOA_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_PESSOA_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'discounts_amounts';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('DESCONTOS_VALORES')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_discount_amount' => $row->ID_DESCONTO_VALOR,
                    'id_discount' => $row->ID_DESCONTO,
                    'date' => $row->DATA,
                    'amount' => $row->VALOR,
                    'created_by' => $row->ID_PESSOA_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_PESSOA_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'clients';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('CLIENTES')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [

                    'id_client' => $row->ID_CLIENTE,
                    'name' => $row->NOME,
                    'short_name' => $row->SIGLA,
                    'zip_code' => $row->CEP,
                    'address' => $row->ENDERECO,
                    'number' => $row->NUMERO,
                    'complement' => $row->COMPLEMENTO,
                    'district' => $row->BAIRRO,
                    'city' => $row->CIDADE,
                    'state' => $row->ESTADO,
                    'created_by' => $row->ID_PESSOA_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_PESSOA_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'authorizations';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('AUTORIZACOES')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [

                    'id_authorization' => $row->ID_AUTORIZACAO,
                    'id_authorization_parent' => $row->ID_AUTORIZACAO_VINC,
                    'id_user' => $row->ID_PESSOA,
                    'id_authorization_type' => ($row->ID_TIPO_AUTORIZACAO == 'D'
                        ? 1
                        : ($row->ID_TIPO_AUTORIZACAO == 'A'
                            ? 2
                            : 3
                        )
                    ),
                    'description' => $row->ANOTACOES,
                    'start_datetime' => ($row->DATAHORA_INICIAL === '0000-00-00 00:00:00' ? $row->DATAHORA_CAD : $row->DATAHORA_INICIAL),
                    'end_datetime' => ($row->DATAHORA_FINAL === '0000-00-00 00:00:00' ? $row->DATAHORA_CAD : $row->DATAHORA_FINAL),
                    'amount' => $row->VALOR,
                    'self' => ($row->SOLICITANTE == 'REC'),
                    'active' => ($row->ATIVO == 'A'),
                    'approved' => ($row->STATUS == 'A'
                        ? 1
                        : ($row->STATUS == 'P'
                            ? null
                            : 0
                        )
                    ),
                    'created_by' => $row->ID_PESSOA_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_PESSOA_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        DB::table($table)->insert([
            'id_authorization' => 1,
            'id_user' => 1,
            'id_authorization_type' => 1,
            'description' => 'Autorização para Despesas Antigas',
            'start_datetime' => '2017-10-01',
            'end_datetime' => '2018-12-29',
            'self' => 1,
            'active' => 0,
            'approved' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        $this->command->info("$table carregada com sucesso");


        $table = 'authorizations_clients';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('AUTORIZACOES_CLIENTES')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_authorization' => $row->ID_AUTORIZACAO,
                    'id_client' => $row->ID_CLIENTE,
                    'created_by' => $row->ID_PESSOA_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_PESSOA_CAD,
                    'updated_at' => $row->DATAHORA_CAD,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'authorizations_statuses';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('AUTORIZACOES_STATUS')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_authorization' => $row->ID_AUTORIZACAO,
                    'id_user' => $row->ID_PESSOA,
                    'approved' => ($row->STATUS == 'A' ? 1 : ($row->STATUS == 'N' ? 0 : null)),
                    'description' => $row->ANOTACOES,
                    'created_by' => $row->ID_PESSOA_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_PESSOA_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");

        $table = 'batches';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        DB::table('batches_clients')->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('LOTES')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_batch' => $row->ID_LOTE,
                    'id_user' => $row->ID_PESSOA,
                    'active' => ($row->STATUS == 'A'),
                    'automatic_batch' => ($row->TIPO_GERACAO == 'A'),
                    'expenses_count' => $row->QTD_DESPESAS,
                    'amount' => $row->VALOR,
                    'refundable_amount' => $row->VALOR_REEMBOLSAVEL,
                    'non_refundable_amount' => $row->VALOR_NAO_REEMBOLSAVEL,
                    'discount' => $row->VALOR_DESCONTO_TABELA ?? 0,
                    'refund_amount' => (($row->VALOR_REEMBOLSAVEL ?? 0) - ($row->VALOR_DESCONTO_TABELA ?? 0)),
                    'user_cash' => $row->ADIANTAMENTO_UTILIZADO ?? 0,
                    'amount_paid' => $row->VALOR_REEMBOLSADO ?? 0,
                    'payment_date' => $row->DATA_REEMBOLSO,
                    'created_by' => $row->ID_PESSOA_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_PESSOA_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'payment_methods';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('FORMAS_PAGAMENTO')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_payment_method' => $row->ID_FORMA_PGTO,
                    'name' => $row->FORMA_PGTO,
                    'refundable' => ($row->EXIGE_REEMBOLSO == 'S'),
                    'created_by' => $row->ID_PESSOA_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_PESSOA_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");

        $table = 'expenses';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('DESPESAS')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_expense' => $row->ID_DESPESA,
                    'id_authorization' => $row->ID_AUTORIZACAO ?? 1,
                    'id_user' => $row->ID_PESSOA,
                    'id_batch' => $row->ID_LOTE,
                    'date' => $row->DATA,
                    'id_category' => $row->ID_TIPO_DESPESA,
                    'id_payment_method' => $row->ID_FORMA_PGTO,
                    'amount' => $row->VALOR,
                    'notes' => $row->ANOTACOES,
                    'created_by' => $row->ID_PESSOA_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_PESSOA_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'batches_discounts';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('LOTES_DESCONTOS')
            ->select('LOTES_DESCONTOS.*', DB::raw('(SELECT MIN(ID_DESPESA) FROM DESPESAS WHERE ID_LOTE = LOTES_DESCONTOS.ID_LOTE AND DATA = LOTES_DESCONTOS.DATA AND ID_TIPO_DESPESA = 1) AS ID_DESPESA'))
            ->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_batch' => $row->ID_LOTE,
                    'id_expense' => $row->ID_DESPESA,
                    'id_discount' => $row->ID_DESCONTO,
                    'expense_amount' => $row->VALOR_DESPESAS,
                    'expense_amount_prev' => $row->VALOR_DESPESAS,
                    'amount' => $row->VALOR_DESCONTADO,
                    'expense_amount_cur' => ($row->VALOR_DESPESAS - $row->VALOR_DESCONTADO),
                    'ref_amount' => $row->VALOR_DESCONTO,
                    'ref_date' => $row->DATA_REAJUSTE,
                    'sequence' => 1,
                    'created_by' => $row->ID_USUARIO_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_USUARIO_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'expenses_clients';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('DESPESAS_CLIENTES')
            ->select('DESPESAS_CLIENTES.*',  DB::raw('(SELECT DESPESAS_CLIENTES.VALOR / VALOR * 100 FROM DESPESAS WHERE ID_DESPESA = DESPESAS_CLIENTES.ID_DESPESA) AS PORCENTO'))
            ->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_expense' => $row->ID_DESPESA,
                    'id_client' => $row->ID_CLIENTE,
                    'amount' => $row->VALOR,
                    'percentage' => $row->PORCENTO,
                    'created_by' => $row->ID_USUARIO_CAD,
                    'created_at' => $row->DATAHORA_CAD,
                    'updated_by' => $row->ID_USUARIO_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'expenses_users';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('DESPESAS_PESSOAS')
            ->select('DESPESAS_PESSOAS.*',  DB::raw('(SELECT DESPESAS_PESSOAS.VALOR / VALOR * 100 FROM DESPESAS WHERE ID_DESPESA = DESPESAS_PESSOAS.ID_DESPESA) AS PORCENTO'))
            ->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                if ($row->PORCENTO) {
                    $batchData[] = [
                        'id_expense' => $row->ID_DESPESA,
                        'id_user' => $row->ID_PESSOA,
                        'amount' => $row->VALOR,
                        'percentage' => $row->PORCENTO,
                        'created_by' => $row->ID_USUARIO_CAD,
                        'created_at' => $row->DATAHORA_CAD,
                        'updated_by' => $row->ID_USUARIO_ALT,
                        'updated_at' => $row->DATAHORA_ALT,
                    ];
                }
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");

        $table = 'batches_clients';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $batches = DB::table('batches')->select('id_batch')->get();
        $key = 0;
        $batchData = [];
        foreach ($batches as $batch) {
            $key++;
            $this->command->warn("Verificando lote ($table) [" . ($key) . "/" . count($batches) . "]");
            $expenses = DB::table('expenses')
                ->where('id_batch', $batch->id_batch)
                ->get();

            $expense_client = DB::table('expenses_clients')->whereIn('id_expense', $expenses->pluck('id_expense')->toArray())->get();
            foreach ($expense_client->groupBy('id_client')->toArray() as $id_client => $client) {
                $amount = array_reduce($client, function ($carry, $expense) {
                    return $carry + $expense->amount;
                }, 0);
                $batchData[] = [
                    'id_batch' => $batch->id_batch,
                    'id_client' => $id_client,
                    'amount' => $amount,
                    'expenses_count' => count($client),
                ];
            }
        }
        $this->command->warn("Inserindo lote $table");
        DB::table($table)->insert($batchData);
        $this->command->info("$table carregada com sucesso");


        $table = 'batches_categories';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $batches = DB::table('batches')->select('id_batch')->get();
        $key = 0;
        $batchData = [];
        foreach ($batches as $batch) {
            $key++;
            $this->command->warn("Verificando lote ($table) [" . ($key) . "/" . count($batches) . "]");

            $expenses = DB::table('expenses')
                ->where('id_batch', $batch->id_batch)
                ->get();

            foreach ($expenses->groupBy('id_category')->toArray() as $id_category => $category) {
                $amount = array_reduce($category, function ($carry, $expense) {
                    return $carry + $expense->amount;
                }, 0);

                $batchData[] = [
                    'id_batch' => $batch->id_batch,
                    'id_category' => $id_category,
                    'amount' => $amount,
                    'expenses_count' => count($category),
                ];
            }
        }
        $this->command->warn("Inserindo lote $table");
        DB::table($table)->insert($batchData);
        $this->command->info("$table carregada com sucesso");


        $table = 'expenses_details';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $expenses = DB::table('expenses')->select('id_expense')->get();
        $key = 0;
        foreach ($expenses as $expense) {
            $key++;
            $this->command->warn("Calculando despesa ($table) [" . ($key) . "/" . count($expenses) . "]");
            ExpenseHelper::refresh($expense->id_expense);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'holidays';
        $this->command->warn("Deletando $table");
        DB::table($table)->where('id_holiday', '>', 12)->delete();
        $this->command->warn("Carregando $table");
        foreach (
            [
                ['Aniversário de Curitiba', 9, 8, [2]],
                ['Aniversário de São Paulo', 1, 25, [1]],
                ['Aniversário de Tatuí', 8, 11, [3]],
                ['Consciência Negra', 11, 20, [1]],
                ['Nossa Senhora da Conceição', 12, 8, [3]],
                ['Nossa Senhora do Navegantes', 2, 2, [4]],
                ['Revolução Constitucionalista', 7, 9, [1, 3]],
                ['Revolução Farroupilha', 9, 20, [4]],
            ] as $row
        ) {
            $id_holiday = DB::table($table)->insertGetId([
                'month' => $row[1],
                'day' => $row[2],
                'name' => $row[0],
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]);

            foreach ($row[3] as $id_branch) {
                DB::table('holidays_branches')->insert([
                    'id_holiday' => $id_holiday,
                    'id_branch' => $id_branch,
                    'created_at' => date("Y-m-d h:i:s"),
                    'updated_at' => date("Y-m-d h:i:s"),
                ]);
            }
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'users_cash';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('SALDO_CONTA')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                if ($row->VALOR > 0) {
                    $batchData[] = [
                        'id_user' => $row->ID_PESSOA,
                        'amount' => $row->VALOR,
                        'created_by' => $row->ID_PESSOA_CAD,
                        'created_at' => $row->DATAHORA_CAD,
                        'updated_by' => $row->ID_PESSOA_ALT,
                        'updated_at' => $row->DATAHORA_ALT,
                    ];
                }
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'users_cash_history';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('ADIANTAMENTOS')->get();
        $batches = array_chunk($data->toArray(), $batchSize);
        foreach ($batches as $key => $batch) {
            $batchData = [];
            foreach ($batch as $row) {
                $batchData[] = [
                    'id_user_cash_history' => $row->ID_ADIANTAMENTO,
                    'id_authorization' => ($row->ID_ADIANTAMENTO == 54 ? null : $row->ID_AUTORIZACAO),
                    'id_batch' => $row->ID_LOTE,
                    'id_user' => $row->ID_PESSOA,
                    'date' => $row->DATA_PGTO ?? $row->DATAHORA,
                    'amount' => $row->VALOR,
                    'previous_balance' => $row->SALDO_ANTERIOR,
                    'current_balance' => $row->NOVO_SALDO,
                    'created_by' => $row->ID_PESSOA_CAD,
                    'created_at' => $row->DATAHORA,
                    'updated_by' => $row->ID_PESSOA_ALT,
                    'updated_at' => $row->DATAHORA_ALT,
                ];
            }
            $this->command->warn("Inserindo lote $table [" . ($key + 1) . "/" . count($batches) . "]");
            DB::table($table)->insert($batchData);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'transactions';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('FINANCEIRO')->get();
        foreach ($data as $row) {
            DB::table($table)->insert([
                'id_transaction' => $row->ID_FINANCEIRO,
                'id_authorization' => $row->ID_AUTORIZACAO,
                'id_user' => $row->ID_PESSOA,
                'id_batch' => $row->ID_LOTE,
                'date' => $row->DATA,
                'amount' => $row->VALOR,
                'description' => ($row->ID_LOTE
                    ? 'Pagamento de Lote'
                    : ($row->ID_AUTORIZACAO
                        ? ($row->VALOR < 0 ? 'Pagamento' : 'Devolução') . ' de Adiantamento'
                        : ''
                    )
                ),
                'type' => ($row->ID_LOTE
                    ? 'batch-payment'
                    : ($row->ID_AUTORIZACAO
                        ? ($row->VALOR < 0 ? 'cash-advance' : 'cash-advance-return')
                        : ''
                    )
                ),
                'created_by' => $row->ID_PESSOA_CAD,
                'created_at' => $row->DATAHORA_CAD,
                'updated_by' => $row->ID_PESSOA_CAD,
                'updated_at' => $row->DATAHORA_CAD,
            ]);

            if ($row->ID_ADIANTAMENTO) {
                DB::table('users_cash_history')
                    ->where('id_user_cash_history', $row->ID_ADIANTAMENTO)
                    ->update(['id_transaction' => $row->ID_FINANCEIRO]);
            }
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'systems';
        $this->command->warn("Deletando $table");
        DB::table($table)->where('id_system', '>', 1)->delete();
        $this->command->warn("Carregando $table");
        DB::table($table)->insert([
            'id_system' => 2,
            'slug' => 'expense-system',
            'name' => 'Despesas',
            'icon' => 'fas fa-hand-holding-usd',
            'created_at' => date("Y-m-d"),
            'updated_at' => date("Y-m-d"),
        ]);
        $this->command->info("$table carregada com sucesso");


        $table = 'users_systems';
        $this->command->warn("Deletando $table");
        DB::table($table)->where('id_system', '>', 1)->delete();
        $this->command->warn("Carregando $table");
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            DB::table($table)->insert([
                'id_user' => $user->id_user,
                'id_system' => 2,
                'created_at' => date("Y-m-d"),
                'updated_at' => date("Y-m-d"),
            ]);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'permissions';
        $this->command->warn("Deletando $table");
        DB::table($table)->where('id_system', '>', 1)->delete();
        $this->command->warn("Carregando $table");
        $routes = DB::table('routes')->whereIn('id_route_group', [3, 4, 5, 6, 7, 8])->get();
        foreach ($routes as $route) {
            DB::table($table)->insert([
                'id_system' => 2,
                'id_route' => $route->id_route,
                'permissions' => $route->permissions,
                'created_at' => date("Y-m-d"),
                'updated_at' => date("Y-m-d"),
            ]);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'profiles';
        $this->command->warn("Deletando $table");
        DB::table($table)->where('id_system', '>', 1)->delete();
        $this->command->warn("Carregando $table");
        Root::run();
        $id_profile = DB::table($table)->insertGetId([
            'name' => 'Recursos',
            'id_system' => 2,
            'created_at' => date("Y-m-d"),
            'updated_at' => date("Y-m-d"),
        ]);
        $this->command->info("$table carregada com sucesso");


        $table = 'permissions';
        $this->command->warn("Deletando $table");
        DB::table($table)->where('id_profile', $id_profile)->delete();
        $this->command->warn("Carregando $table");
        $routes = DB::table('routes')->whereIn('id_route_group', [5])->get();
        foreach ($routes as $route) {
            DB::table($table)->insert([
                'id_system' => 2,
                'id_route' => $route->id_route,
                'id_profile' => $id_profile,
                'permissions' => $route->permissions,
                'created_at' => date("Y-m-d"),
                'updated_at' => date("Y-m-d"),
            ]);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'users_profiles';
        $this->command->warn("Deletando $table");
        DB::table($table)->where('id_profile', $id_profile)->delete();
        $this->command->warn("Carregando $table");
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            DB::table($table)->insert([
                'id_user' => $user->id_user,
                'id_profile' => $id_profile,
                'created_at' => date("Y-m-d"),
                'updated_at' => date("Y-m-d"),
            ]);
        }
        $this->command->info("$table carregada com sucesso");


        $table = 'users_teams';
        $this->command->warn("Deletando $table");
        DB::table($table)->truncate();
        DB::table('users_authorizations_types')->truncate();
        $this->command->warn("Carregando $table");
        $data = DB::connection('mysql_old')->table('PESSOAS_RESPONSAVEIS')->get();
        foreach ($data as $row) {
            $id_user_team = DB::table($table)->insertGetId([
                'id_user_parent' => $row->ID_PESSOA_RESP,
                'id_user_child' => $row->ID_PESSOA_SUB,
                'created_by' => $row->ID_PESSOA_CAD,
                'created_at' => $row->DATAHORA_CAD,
                'updated_by' => $row->ID_PESSOA_CAD,
                'updated_at' => $row->DATAHORA_CAD,
            ]);

            $types = [1 => 'APROVA_DESPESA', 4 => 'APROVA_HORA_EXTRA', 2 => 'APROVA_ADIANTAMENTO', 3 => 'APROVA_ADIANTAMENTO'];

            foreach ($types as $id_authorization_type => $type) {
                if ($row->{$type} == 'S') {
                    DB::table('users_authorizations_types')->insert([
                        'id_user_team' => $id_user_team,
                        'id_user_parent' => $row->ID_PESSOA_RESP,
                        'id_user_child' => $row->ID_PESSOA_SUB,
                        'id_authorization_type' => $id_authorization_type,
                        'created_by' => $row->ID_PESSOA_CAD,
                        'created_at' => $row->DATAHORA_CAD,
                        'updated_by' => $row->ID_PESSOA_CAD,
                        'updated_at' => $row->DATAHORA_CAD,
                    ]);
                }
            }
        }
        $this->command->info("$table carregada com sucesso");

        DB::statement('DELETE FROM users_authorizations_types WHERE id_authorization_type NOT IN (SELECT id_authorization_type FROM authorizations_types)');

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Root::run();
    }
}
