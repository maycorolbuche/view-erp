# Consultas e relatórios

[Voltar ao manual](../README.md) · [Inventário completo](../inventario.md)

Os caminhos abaixo são relativos ao sistema selecionado; veja a convenção de endereços no guia de acesso.

<a id="queries-authorizations"></a>

## Autorizações

**Menu:** Consultas. **Caminho relativo:** `/queries/authorizations`.

Consultar autorizações dos usuários com seus responsáveis e respostas.

**Como usar.** Localize a autorização, abra os detalhes e confira tipo, solicitante, período/data, motivo, clientes, respostas e comprovante de devolução quando existente.

**Regras e efeitos.** Consulta geral não é a tela de resposta. Para aprovar ou recusar uma solicitação atribuída a você, use Autorizações em Meu acesso. Sem permissão de consulta geral, use apenas suas autorizações.

**Ações apresentadas:** Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, Tipo, Período, Descrição, Clientes, Autorizações, Status, Dt. Cadastro. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Gravação:** esta tela é de consulta; não há operação de cadastro, alteração ou exclusão no controlador.

**Referência de conferência:** [AuthorizationController.php](../../../app/Http/Controllers/Query/AuthorizationController.php), [authorizations.blade.php](../../../resources/views/queries/authorizations.blade.php).

<a id="queries-expenses"></a>

## Despesas

**Menu:** Consultas. **Caminho relativo:** `/queries/expenses`.

Consultar despesas de todos os usuários e simular valores por categoria.

**Como usar.** Informe período e os filtros de lote, status, tipo de despesa, tipo de pagamento, cliente e usuário. Abra o detalhe para consultar rateios e comprovante. Na aba Simulador, altere os valores e quantidades para calcular médias.

**Regras e efeitos.** A simulação só altera os números exibidos na página e não grava despesas. O filtro de usuário considera os usuários do rateio. O simulador aplica os filtros de período, lote, categoria, pagamento, cliente e usuário; não aplica o filtro de status usado na grid.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data Inicial | `start_date` | Data | Não marcado |
| Data Final | `end_date` | Data | Não marcado |
| Lote | `id_batch` | Número | Não marcado |
| Status | `status` | Seleção | Não marcado |
| Tipo de Despesa | `id_category` | Seleção | Não marcado |
| Tipo de Pagamento | `id_payment_method` | Seleção | Não marcado |
| Cliente | `id_client` | Seleção | Não marcado |
| Usuário | `id_user` | Seleção | Não marcado |

**Ações apresentadas:** Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Data, Nome, Tipo de Despesa, Clientes, Tipo de Pagamento, Valor, Reembolsável?, Lote, Status Lote. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Gravação:** esta tela é de consulta; não há operação de cadastro, alteração ou exclusão no controlador.

**Referência de conferência:** [ExpenseController.php](../../../app/Http/Controllers/Query/ExpenseController.php), [expenses.blade.php](../../../resources/views/queries/expenses.blade.php), [expenses-simulator.blade.php](../../../resources/views/queries/partials/expenses-simulator.blade.php).

<a id="queries-batches"></a>

## Lotes

**Menu:** Consultas. **Caminho relativo:** `/queries/batches`.

Consultar lotes de todos os usuários e seus resultados financeiros.

**Como usar.** Filtre período e usuário, abra o lote e examine itens, descontos, gráficos por categoria/cliente, dados do pagamento e impressão.

**Regras e efeitos.** O período filtra a criação do lote. A consulta não aprova nem paga. A impressão é um PDF com dados do lote; nesta versão, o código não impõe aprovação prévia para gerá-lo.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data Inicial | `start_date` | Data | Não marcado |
| Data Final | `end_date` | Data | Não marcado |
| Usuário | `id_user` | Seleção | Não marcado |

**Ações apresentadas:** Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Data/Hora, Nome, Qtd. Despesas, Vl. Reembolsável, Vl. Não Reembolsável, Vl. Total, Status. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Gravação:** esta tela é de consulta; não há operação de cadastro, alteração ou exclusão no controlador.

**Referência de conferência:** [BatchController.php](../../../app/Http/Controllers/Query/BatchController.php), [batches.blade.php](../../../resources/views/queries/batches.blade.php).

<a id="reports-users"></a>

## Por Usuários

**Menu:** Relatórios. **Caminho relativo:** `/reports/users`.

Analisar a distribuição de despesas pelos usuários beneficiados no rateio.

**Como usar.** Escolha datas inicial e final e clique Exibir; leia o total geral e o detalhamento por categoria de cada usuário.

**Regras e efeitos.** O período padrão é o mês atual. Os valores vêm do rateio por usuário e da data da despesa, não da data de pagamento do lote. Não é um relatório de transferências ou de folha de pagamento.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data Inicial | `start_date` | Data | Sim |
| Data Final | `end_date` | Data | Sim |

**Gravação:** esta tela é de consulta; não há operação de cadastro, alteração ou exclusão no controlador.

**Referência de conferência:** [UserController.php](../../../app/Http/Controllers/Report/UserController.php), [users.blade.php](../../../resources/views/reports/users.blade.php).

<a id="reports-clients"></a>

## Por Clientes

**Menu:** Relatórios. **Caminho relativo:** `/reports/clients`.

Analisar os gastos atribuídos aos clientes.

**Como usar.** Escolha o período, clique Exibir e consulte totais por cliente, detalhamento por categoria e gráficos.

**Regras e efeitos.** Usa os valores rateados para cada cliente e a data da despesa. Abrange despesas no período independentemente de o lote já ter sido pago.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data Inicial | `start_date` | Data | Sim |
| Data Final | `end_date` | Data | Sim |

**Gravação:** esta tela é de consulta; não há operação de cadastro, alteração ou exclusão no controlador.

**Referência de conferência:** [ClientController.php](../../../app/Http/Controllers/Report/ClientController.php), [clients.blade.php](../../../resources/views/reports/clients.blade.php).

<a id="reports-expenses"></a>

## Por Tipo de Despesas

**Menu:** Relatórios. **Caminho relativo:** `/reports/expenses`.

Analisar os gastos por tipo de despesa, com distribuição por clientes e usuários.

**Como usar.** Escolha o período, clique Exibir e examine os totais por categoria, as distribuições e os gráficos.

**Regras e efeitos.** O total geral vem das despesas; os detalhamentos por cliente e usuário vêm dos rateios. Compare períodos equivalentes e não confunda despesa com saída de caixa.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data Inicial | `start_date` | Data | Sim |
| Data Final | `end_date` | Data | Sim |

**Gravação:** esta tela é de consulta; não há operação de cadastro, alteração ou exclusão no controlador.

**Referência de conferência:** [ExpenseController.php](../../../app/Http/Controllers/Report/ExpenseController.php), [expenses.blade.php](../../../resources/views/reports/expenses.blade.php).
