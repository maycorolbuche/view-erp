# Dúvidas, mensagens e limites atuais

[Voltar ao manual](../README.md)

## Problemas frequentes

| Sintoma ou mensagem | O que conferir | Encaminhamento |
|---|---|---|
| Usuário inativo | Situação na tela Usuários | Administrador deve avaliar a ativação |
| Nenhum sistema disponível | Vínculos em Sistemas Usuários | Administrador concede o sistema adequado |
| Sem Módulos Autorizados | Perfis e acessos diretos no sistema escolhido | Administrador revisa módulos e operações |
| Página não autorizada/403 | Permissão da rota e sistema selecionado | Solicitar acesso; trocar cargo não resolve |
| Página não encontrada/404 | Nome URL do sistema, caminho e acesso ao sistema | Abrir pelo menu e conferir a instalação |
| Registro não encontrado | Código, existência, propriedade e etapa do registro | Verificar na consulta apropriada; lote pago deixa a fila de pagamento |
| Não há pessoa para aprovar | Relação de equipe e tipos marcados | Configurar aprovadores específicos |
| Não há autorização disponível para despesa | Aprovação, atividade, proprietário e período | Solicitar/concluir autorização de despesa |
| Categoria não aparece | Tipo Despesa e vínculos de usuários | Administrador revisa a categoria |
| Data fora do período autorizado | Data inicial/final da autorização | Corrigir a data ou seguir novo processo de autorização |
| Soma dos clientes/usuários diferente da despesa | Rateios e arredondamentos | Cada grupo de rateio deve somar o valor integral da despesa |
| Despesa desapareceu do cadastro | Já vinculada a lote ou autorização inativa | Consultar em Meus Lotes/Consultas; verificar tarefas de remoção |
| Desconto não foi aplicado | Pessoa vinculada, categorias, vigência, dia útil e reembolsabilidade | Conferir o detalhe e a regra de cálculo |
| Não é possível desfazer lote | Etapa, atividade, revisão e autorizações das despesas | Ler motivo; não existe reabertura padrão de lote aprovado/pago |
| Lote aprovado, mas sem pagamento | Há diferença entre aprovação e baixa | Financeiro deve verificar a fila de pagamentos |
| Lote concluído com valor pago zero | Compensação de saldo, reembolso líquido zero ou lote não reembolsável | Conferir totais e histórico antes de considerar erro |
| Ainda existe saldo após o lote | Lote não baixado ou reembolso menor que o saldo | Conferir pagamentos pendentes e devolver saldo quando cabível |
| Já existe solicitação de devolução em andamento | Devolução ativa anterior | Aguardar decisão dos responsáveis |
| Comprovante obrigatório ou formato/tamanho inválido | Arquivo, extensão, tamanho e limites do servidor | Selecionar comprovante válido e reenviar |
| Comprovante antigo não aparece | Registro anterior à implantação ou arquivo indisponível | Verificar dados e armazenamento com suporte |
| E-mail falhou depois de salvar | Registro principal pode já ter sido gravado | Consultar antes de repetir a operação |
| E-mail “Enviado” não chegou | Endereço, spam e provedor | Suporte verifica envio; status não é leitura/entrega confirmada |
| Pendência do lembrete não bate com tela | Limitação da montagem do e-mail de pendências | Usar as filas operacionais como referência e avisar suporte |
| Não é possível excluir um cadastro | Registro raiz ou referências existentes | Avaliar dependências; não forçar exclusão para resolver erro de formulário |
| Tarefa parece concluída, mas operação falhou | Saída detalhada da tarefa | Analisar os detalhes, não apenas o horário de término |

## Recursos que não devem ser presumidos

| Assunto | Situação na revisão documentada |
|---|---|
| Extrato unificado de lotes, adiantamentos e devoluções | Não identificado; existe histórico de alterações de saldo |
| Validação de depósito em fila própria no Financeiro | Não identificada; aprovação ocorre pelas Autorizações |
| Comprovante de devolução obrigatório | Implementado; necessário para novas solicitações |
| Impressão somente depois de aprovar o lote | Não implementada; links e gerador não exigem esse status |
| Resumo completo e mensagem de saldo no e-mail de aprovação do colaborador | Não implementados nessa mensagem; o resumo existe na comunicação de novo lote aos inscritos |
| Transferência bancária automática | Não identificada; o ERP registra a baixa |
| Pagamento automático na data prevista | Não identificado; a previsão não substitui a confirmação da baixa |
| Gerar lote automático pelo prazo “sem reembolso” | A tarefa existente encerra lotes já criados |
| Estorno/reabertura padrão de lote pago | Não identificados nas ações normais das telas |
| Anexo de atestado | Não identificado na tela de Atestados |
| Aprovação automática de férias | Não identificada; a tela mantém campos de períodos |
| Captura de leitura/entrega de e-mails | Não identificada no log de envio |
| Reenvio de e-mail pelo histórico | Não identificado |
| Backup diário dos comprovantes | O comando agendado pede somente banco de dados |
| Busca auxiliar de usuários em rota própria | Há controlador/view, mas as rotas estão comentadas |

## Particularidades que afetam a interpretação

**Senha vazia na manutenção administrativa.** A tela de Usuários orienta deixar senha em branco para não alterar. Entretanto, o controlador aceita o campo enviado e o mutator do modelo sempre gera um hash; não há exclusão explícita de senha vazia nessa gravação. A orientação visual não é garantia de preservação da senha existente. O suporte deve conferir esse comportamento antes da manutenção de credenciais.

**Datas de pagamento vazias.** O fechamento pela conferência sem valor reembolsável não usa o mesmo caminho da baixa de pagamento. Algumas telas formatam datas sem testar explicitamente se estão preenchidas. Confirme a informação do lote antes de interpretar a data exibida como pagamento real.

**Prazo de autorização.** A tarefa diária considera prazo e respostas recentes. A consolidação de respostas tem ainda regra própria baseada em diferença de dias e encerra adiantamentos/devoluções com decisão. Não existe um único comportamento uniforme de expiração para todos os eventos.

**Saldo negativo.** O helper de saldo não aplica um piso geral de zero. O limite de devolução é validado no envio da solicitação, mas não há uma reserva de saldo enquanto aguarda aprovação. Operações simultâneas, baixas intermediárias ou ajustes merecem conferência financeira.

**Descontos por dia.** A distribuição do desconto é calculada dentro do lote. Dividir despesas do mesmo dia em lotes distintos não corresponde a uma garantia de limite global diário.

**Filtro do simulador.** A consulta de despesas tem filtro de status na grid. O carregamento do simulador aplica os outros filtros definidos no controlador, sem o mesmo filtro de status. Os totais podem divergir por esse motivo.

**Rótulos reaproveitados.** Algumas listagens de especializações, atestados e advertências usam “Lista de Pagamentos”. As rotinas e os dados continuam sendo os do módulo correspondente; esse título não cria um fluxo de pagamento.

**Escopo por sistema.** O sistema selecionado controla a navegação e permissões. Não há garantia geral de isolamento de todos os dados de negócio por sistema: consultas financeiras e cadastros podem usar tabelas compartilhadas, conforme os controladores. Não tratar sistemas como empresas com bancos de dados separados.

## Como registrar uma dúvida para o suporte

Informe o nome da tela, sistema selecionado, código da autorização/despesa/lote, data e hora, ação utilizada e mensagem apresentada. Em divergência financeira, inclua o valor esperado, os totais do lote e o saldo visto no histórico.

Antes de repetir uma ação de pagamento, aprovação ou ajuste, confirme se ela já deixou registros. Anexe somente os dados necessários para o atendimento e siga o procedimento da empresa para documentos pessoais e comprovantes.

## Referências da revisão

[Histórico de saldo](../../../app/Helpers/UserHelper.php), [conferência](../../../app/Http/Controllers/Finance/BatchReviewController.php), [pagamento](../../../app/Http/Controllers/Finance/BatchPaymentController.php), [PDF](../../../app/Http/Controllers/PdfController.php), [simulador](../../../app/Http/Controllers/Query/ExpenseController.php), [lembrete](../../../app/Notifications/PendingBatchesNotification.php), [rotinas](../../../app/Console/Commands), [inventário](../inventario.md).
