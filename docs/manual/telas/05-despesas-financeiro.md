# Despesas e financeiro

[Voltar ao manual](../README.md) · [Inventário completo](../inventario.md)

Os caminhos abaixo são relativos ao sistema selecionado; veja a convenção de endereços no guia de acesso.

<a id="authorizations-expenses"></a>

## Solicitação de Despesas

**Menu:** Despesas. **Caminho relativo:** `/authorizations-expenses`.

Solicitar autorização para despesas em um período e para determinados clientes.

**Como usar.** Informe datas inicial e final, motivo e clientes; confira os responsáveis exibidos e cadastre. Acompanhe o resultado em Autorizações.

**Regras e efeitos.** As duas datas, motivo e clientes são obrigatórios; final não pode anteceder início. Sem responsável configurado na equipe, a solicitação é bloqueada. O envio de e-mail é posterior ao cadastro e pode falhar sem desfazê-lo.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data Inicial | `start_date` | Data | Sim |
| Data Final | `end_date` | Data | Sim |
| Motivo da Solicitação | `description` | Texto | Sim |
| Clientes Envolvidos | `id_client` | Seleção múltipla | Sim |

**Ações apresentadas:** Cadastrar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Data Inicial, Data Final, Descrição, Clientes, Autorizações, Status. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [AuthorizationExpenseController.php](../../../app/Http/Controllers/Authorization/AuthorizationExpenseController.php), [index.blade.php](../../../resources/views/authorizations-expenses/index.blade.php), [AuthorizationExpenseRequest.php](../../../app/Http/Requests/AuthorizationExpenseRequest.php).

<a id="expenses"></a>

## Cadastro de Despesas

**Menu:** Despesas. **Caminho relativo:** `/expenses`.

Registrar as despesas do usuário, comprovantes e rateios.

**Como usar.** Escolha autorização aprovada e ativa, data, categoria, valor e tipo de pagamento; distribua o valor entre clientes e usuários, anexe o comprovante e cadastre. A opção Distribuir permite repartir em vários dias úteis.

**Regras e efeitos.** A data deve estar no período autorizado e cada rateio deve somar o valor total da despesa. Só aparecem despesas próprias, sem lote e com autorização ativa para manutenção. Não é permitido trocar a autorização na edição. Comprovantes aceitam JPG/JPEG, PNG e PDF até 20 MB; a obrigatoriedade segue Configurações Gerais.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Autorização | `id_authorization` | Seleção | Sim |
| Data | `date` | Data | Sim |
| Tipo de Despesa | `id_category` | Seleção | Sim |
| Valor | `amount` | Valor monetário | Sim |
| Tipo de Pagamento | `id_payment_method` | Seleção | Sim |
| Qtd. dias | `_distribute` | Número | Não marcado |
| Comprovante da Despesa | `file` | Arquivo | Condicional |
| Anotações / Observações | `notes` | Texto longo | Não marcado |

**Ações apresentadas:** Cadastrar, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Data, Tipo de Despesa, Clientes, Tipo de Pagamento, Valor, Reembolsável?. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [ExpenseController.php](../../../app/Http/Controllers/Expense/ExpenseController.php), [index.blade.php](../../../resources/views/expenses/index.blade.php), [ExpenseRequest.php](../../../app/Http/Requests/ExpenseRequest.php).

<a id="authorizations-cash-advances"></a>

## Solic. Adiantamento

**Menu:** Despesas. **Caminho relativo:** `/authorizations-cash-advances`.

Solicitar adiantamento vinculado a uma autorização de despesas.

**Como usar.** Escolha autorização de despesa ativa/aprovada, informe valor e motivo, confira responsáveis e aceite o termo quando configurado.

**Regras e efeitos.** Valor deve ser pelo menos R$ 0,01. Sem responsável não há solicitação. A solicitação sozinha não altera saldo: o crédito é lançado após a aprovação consolidada. O texto do termo aceito é gravado na solicitação.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Autorização de Despesa | `id_authorization_parent` | Seleção | Sim |
| Valor | `amount` | Valor monetário | Sim |
| Motivo da Solicitação | `description` | Texto | Sim |

**Ações apresentadas:** Cadastrar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Data, Valor, Descrição, Autorizações, Status. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [AuthorizationCashAdvanceController.php](../../../app/Http/Controllers/Authorization/AuthorizationCashAdvanceController.php), [index.blade.php](../../../resources/views/authorizations-cash-advances/index.blade.php), [AuthorizationCashAdvanceRequest.php](../../../app/Http/Requests/AuthorizationCashAdvanceRequest.php).

<a id="authorizations-cash-advance-returns"></a>

## Dev. Adiantamento

**Menu:** Despesas. **Caminho relativo:** `/authorizations-cash-advance-returns`.

Solicitar devolução de saldo e anexar o comprovante do depósito.

**Como usar.** Confira o saldo, informe valor e motivo, anexe o comprovante obrigatório e cadastre. Consulte o arquivo nos detalhes da autorização.

**Regras e efeitos.** Exige saldo positivo, valor mínimo de R$ 0,01 e máximo igual ao saldo atual; bloqueia uma segunda devolução ativa. Aceita JPG/JPEG, PNG ou PDF até 20 MB. Na gravação, autorização, arquivo e responsáveis ficam associados; falha no cadastro desfaz o registro e remove o arquivo enviado. A redução do saldo depende da aprovação, não do upload.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Valor | `amount` | Valor monetário | Sim |
| Motivo da Devolução | `description` | Texto | Sim |
| Comprovante de Devolução | `file` | Arquivo | Sim |

**Ações apresentadas:** Cadastrar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Data, Valor, Descrição, Autorizações, Status. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [AuthorizationCashAdvanceReturnController.php](../../../app/Http/Controllers/Authorization/AuthorizationCashAdvanceReturnController.php), [index.blade.php](../../../resources/views/authorizations-cash-advance-returns/index.blade.php), [AuthorizationCashAdvanceReturnRequest.php](../../../app/Http/Requests/AuthorizationCashAdvanceReturnRequest.php).

<a id="batches"></a>

## Gerar Lote

**Menu:** Despesas. **Caminho relativo:** `/batches`.

Agrupar despesas próprias elegíveis e calcular o lote.

**Como usar.** Selecione ao menos uma despesa da lista e clique Gerar Lote. Confira os totais em Meus Lotes após a geração.

**Regras e efeitos.** A lista considera despesas sem lote e com autorização ativa. A geração vincula as despesas, consolida clientes/categorias e calcula descontos; não paga o colaborador nem abate o adiantamento. As despesas saem da manutenção individual enquanto vinculadas.

**Ações apresentadas:** Gerar Lote, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Referência de conferência:** [BatchController.php](../../../app/Http/Controllers/Batch/BatchController.php), [index.blade.php](../../../resources/views/batches/index.blade.php), [BatchRequest.php](../../../app/Http/Requests/BatchRequest.php).

<a id="batch-review"></a>

## Conferência de Lotes

**Menu:** Financeiro. **Caminho relativo:** `/batch-review`.

Conferir lotes e aprovar seu encaminhamento ao pagamento.

**Como usar.** Abra um lote pendente, clique Iniciar Revisão, confira os itens e comprovantes, marque a revisão das despesas e informe agendamento e anotações. Use Aprovar Lote, Fechar Lote ou Reprovar Lote conforme o caso.

**Regras e efeitos.** Reprovação exige motivo em Anotações. Sem valor reembolsável, a aprovação fecha o lote com valor pago e adiantamento utilizado iguais a zero. Com valor reembolsável, encaminha para pagamento. Conferir não abate o saldo; esse abatimento é feito em Pagamentos de Lotes.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data Agendamento do Pagamento | `estimated_payment_date` | Data | Não marcado |
| Anotações | `notes` | Texto longo | Não marcado |

**Ações apresentadas:** Iniciar Revisão, Cancelar, Reprovar Lote, Fechar Lote, Aprovar Lote. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Lote, Data/Hora, Nome, Qtd. Despesas, Vl. Reembolsável, Vl. Não Reembolsável, Vl. Total, Status. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [BatchReviewController.php](../../../app/Http/Controllers/Finance/BatchReviewController.php), [index.blade.php](../../../resources/views/batch-review/index.blade.php).

<a id="batch-payments"></a>

## Pagamentos de Lotes

**Menu:** Financeiro. **Caminho relativo:** `/batch-payments`.

Registrar a baixa dos lotes ativos aprovados.

**Como usar.** Abra o lote na fila, confira o valor de reembolso e o saldo do colaborador e confirme a ação de pagamento/encerramento.

**Regras e efeitos.** O sistema usa o saldo disponível até o limite do reembolso líquido, registra a data atual, o adiantamento utilizado e o valor pago, e fecha o lote. Só cria saída no fluxo de caixa quando existe valor efetivamente pago. O registro não executa transferência em banco.

**Ações apresentadas:** Efetuar pagamento (quando há valor positivo a pagar) ou Fechar Lote (quando o valor exibido é zero), Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Lote, Data Lote, Data Conferência, Data p/ Pgto., Nome, Vl. Reemb., Vl. Não Reemb., Vl. Total. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [BatchPaymentController.php](../../../app/Http/Controllers/Finance/BatchPaymentController.php), [index.blade.php](../../../resources/views/batch-payments/index.blade.php).

<a id="cash-advances"></a>

## Adiantamentos

**Menu:** Financeiro. **Caminho relativo:** `/cash-advances`.

Consultar saldos por colaborador e registrar ajustes manuais.

**Como usar.** Abra o colaborador, confira o histórico, informe valor e motivo e use Pagar para aumentar ou Estornar para diminuir o saldo.

**Regras e efeitos.** Valor zero e motivo vazio são bloqueados. As ações alteram saldo, histórico e transações. Não há uma fila própria de validação de depósitos nesta tela; a devolução segue o fluxo de autorizações. Não repetir um ajuste para um adiantamento já lançado na aprovação.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Valor | `amount` | Valor monetário | Sim |
| Motivo | `description` | Texto | Sim |

**Ações apresentadas:** Pagar, Estornar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Data/Hora, Descrição, Saldo Anterior, Valor, Saldo Posterior, Código, Nome, Saldo de Adiantamento. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [CashAdvanceController.php](../../../app/Http/Controllers/Finance/CashAdvanceController.php), [index.blade.php](../../../resources/views/cash-advances/index.blade.php).

<a id="cash-flow"></a>

## Fluxo de Caixa

**Menu:** Financeiro. **Caminho relativo:** `/cash-flow`.

Consultar as transações financeiras registradas pelo ERP.

**Como usar.** Consulte código, data, descrição e valor; use a pesquisa e a ordenação da listagem para localizar a movimentação.

**Regras e efeitos.** É uma consulta sem cadastro ou edição de transações nesta tela. Valores negativos representam saídas e positivos entradas. O saldo de adiantamento do colaborador tem convenção diferente: receber adiantamento aumenta esse saldo.

**Colunas das listagens:** Código, Data, Descrição, Valor. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Gravação:** esta tela é de consulta; não há operação de cadastro, alteração ou exclusão no controlador.

**Referência de conferência:** [CashFlowController.php](../../../app/Http/Controllers/Finance/CashFlowController.php), [index.blade.php](../../../resources/views/cash-flow/index.blade.php).
