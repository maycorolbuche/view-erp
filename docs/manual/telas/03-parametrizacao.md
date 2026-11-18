# Parametrização

[Voltar ao manual](../README.md) · [Inventário completo](../inventario.md)

Os caminhos abaixo são relativos ao sistema selecionado; veja a convenção de endereços no guia de acesso.

<a id="configs"></a>

## Configurações Gerais

**Menu:** Parametrização. **Caminho relativo:** `/configs`.

Parametrizar autorizações, comprovantes, fechamento de lotes e previsão de pagamento.

**Como usar.** Revise os cinco parâmetros e salve. Consulte o capítulo de rotinas para entender os prazos.

**Regras e efeitos.** O parâmetro de anexo obrigatório controla despesas; o comprovante de devolução é sempre obrigatório. O campo de lote automático tem rótulo de geração, mas a rotina associada encerra lotes já existentes, sem reembolso.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Qtd. dias para encerrar autorização | `authorizationsActiveDays_to_close` | Número | Não marcado |
| Termo de Consentimento - Solicitação de Adiantamento | `authorizationsCash_advanceAgreement_terms` | Texto longo | Não marcado |
| Anexo de arquivo obrigatório | `expensesRequiredFile` | Sim/Não | Não marcado |
| Qtd. dias para gerar lote automático sem reembolso | `batchesActiveDays_to_close_without_refund` | Número | Não marcado |
| Qtd. dias padrão para pagamento de lote | `batchesStandard_payment_days` | Número | Não marcado |

**Ações apresentadas:** Salvar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Referência de conferência:** [ConfigController.php](../../../app/Http/Controllers/Config/ConfigController.php), [index.blade.php](../../../resources/views/configs/index.blade.php), [ConfigRequest.php](../../../app/Http/Requests/ConfigRequest.php).

<a id="clients"></a>

## Clientes

**Menu:** Parametrização. **Caminho relativo:** `/clients`.

Manter os clientes envolvidos nas autorizações e no rateio de despesas.

**Como usar.** Cadastre nome, abreviação e endereço. Selecione um registro para editar ou excluir.

**Regras e efeitos.** Nome e abreviação são obrigatórios; a abreviação deve ser única. Clientes são usados nas solicitações, na distribuição de despesas, nos lotes e nos relatórios. Vínculos existentes podem impedir exclusão.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |
| Nome Abreviado | `short_name` | Texto | Sim |
| CEP | `zip_code` | CEP | Não marcado |
| Endereço | `address` | Texto | Não marcado |
| Nº | `number` | Texto | Não marcado |
| Complemento | `complement` | Texto | Não marcado |
| Bairro | `district` | Texto | Não marcado |
| Cidade | `city` | Texto | Não marcado |
| Estado | `state` | Texto | Não marcado |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [ClientController.php](../../../app/Http/Controllers/Client/ClientController.php), [index.blade.php](../../../resources/views/clients/index.blade.php), [ClientRequest.php](../../../app/Http/Requests/ClientRequest.php).

<a id="branches"></a>

## Filiais

**Menu:** Parametrização. **Caminho relativo:** `/branches`.

Manter filiais, seus endereços e a referência de calendário das pessoas.

**Como usar.** Informe nome, abreviação e endereço; cadastre ou salve o registro selecionado.

**Regras e efeitos.** Nome e abreviação são obrigatórios; a abreviação é única. A filial participa dos feriados aplicáveis e dos cálculos de dias úteis. A previsão de pagamento usa a filial de quem faz a conferência.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |
| Nome Abreviado | `short_name` | Texto | Sim |
| CEP | `zip_code` | CEP | Não marcado |
| Endereço | `address` | Texto | Não marcado |
| Nº | `number` | Texto | Não marcado |
| Complemento | `complement` | Texto | Não marcado |
| Bairro | `district` | Texto | Não marcado |
| Cidade | `city` | Texto | Não marcado |
| Estado | `state` | Texto | Não marcado |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [BranchController.php](../../../app/Http/Controllers/Branch/BranchController.php), [index.blade.php](../../../resources/views/branches/index.blade.php), [BranchRequest.php](../../../app/Http/Requests/BranchRequest.php).

<a id="holidays"></a>

## Feriados

**Menu:** Parametrização. **Caminho relativo:** `/holidays`.

Definir feriados gerais ou restritos a filiais.

**Como usar.** Informe nome e tipo: data específica, repetição anual ou deslocamento relativo à Páscoa. Preencha data ou quantidade de dias e selecione as filiais aplicáveis.

**Regras e efeitos.** Sem filiais vinculadas, o feriado é geral. A repetição anual ignora o ano; o relativo à Páscoa usa o deslocamento. Afeta distribuição de despesas, descontos e previsão de pagamento.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |
| Tipo | `type` | Opção | Não marcado |
| Data | `date` | Data | Sim |
| Qtd. Dias ref. Páscoa | `easter` | Número | Sim |
| Filiais | `id_branch` | Marcação | Não marcado |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Data, Nome, Tipo, Filiais. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [HolidayController.php](../../../app/Http/Controllers/Holiday/HolidayController.php), [index.blade.php](../../../resources/views/holidays/index.blade.php), [HolidayRequest.php](../../../app/Http/Requests/HolidayRequest.php).

<a id="roles"></a>

## Cargos

**Menu:** Parametrização. **Caminho relativo:** `/roles`.

Manter o catálogo de cargos e funções.

**Como usar.** Cadastre o nome do cargo. Vincule depois a uma pessoa em Cargos/Funções, com seu período.

**Regras e efeitos.** O cadastro do cargo não concede permissões de acesso nem o transforma em aprovador. Esses vínculos são mantidos em telas próprias.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [RoleController.php](../../../app/Http/Controllers/Role/RoleController.php), [index.blade.php](../../../resources/views/roles/index.blade.php), [RoleRequest.php](../../../app/Http/Requests/RoleRequest.php).

<a id="civil-statuses"></a>

## Estados Civis

**Menu:** Parametrização. **Caminho relativo:** `/civil-statuses`.

Manter os estados civis disponíveis no cadastro de pessoas.

**Como usar.** Informe a descrição e cadastre; selecione um registro para alterar ou excluir.

**Regras e efeitos.** A descrição é obrigatória. O efeito é cadastral e não altera os cálculos financeiros.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Descrição | `description` | Texto | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Descrição. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [CivilStatusController.php](../../../app/Http/Controllers/CivilStatus/CivilStatusController.php), [index.blade.php](../../../resources/views/civil-statuses/index.blade.php), [CivilStatusRequest.php](../../../app/Http/Requests/CivilStatusRequest.php).

<a id="payment-methods"></a>

## Formas de Pagamento

**Menu:** Parametrização. **Caminho relativo:** `/payment-methods`.

Definir os tipos de pagamento e se uma despesa permite reembolso.

**Como usar.** Cadastre o nome e marque Reembolsável conforme a regra da empresa.

**Regras e efeitos.** A classificação entra nos totais reembolsáveis e não reembolsáveis durante a geração do lote. Não representa uma transferência bancária feita pelo ERP.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |
| Reembolsável? | `refundable` | Sim/Não | Não marcado |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, Rembolsável?. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [PaymentMethodController.php](../../../app/Http/Controllers/PaymentMethod/PaymentMethodController.php), [index.blade.php](../../../resources/views/payment-methods/index.blade.php), [PaymentMethodRequest.php](../../../app/Http/Requests/PaymentMethodRequest.php).

<a id="employment-types"></a>

## Vínculos Trabalho

**Menu:** Parametrização. **Caminho relativo:** `/employment-types`.

Manter os vínculos de trabalho/tipos de recurso das pessoas.

**Como usar.** Cadastre uma descrição e selecione esse vínculo no cadastro da pessoa.

**Regras e efeitos.** A descrição é obrigatória. O vínculo de trabalho não substitui o perfil de acesso.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Descrição | `description` | Texto | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Descrição. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [EmploymentTypeController.php](../../../app/Http/Controllers/EmploymentType/EmploymentTypeController.php), [index.blade.php](../../../resources/views/employment-types/index.blade.php), [EmploymentTypeRequest.php](../../../app/Http/Requests/EmploymentTypeRequest.php).

<a id="carriers"></a>

## Operadoras Telefonia

**Menu:** Parametrização. **Caminho relativo:** `/carriers`.

Manter as operadoras utilizadas nos telefones das pessoas.

**Como usar.** Cadastre o nome da operadora e utilize-o em Telefones.

**Regras e efeitos.** É um cadastro auxiliar; não envia mensagens nem faz integração com a operadora.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [CarrierController.php](../../../app/Http/Controllers/Carrier/CarrierController.php), [index.blade.php](../../../resources/views/carriers/index.blade.php), [CarrierRequest.php](../../../app/Http/Requests/CarrierRequest.php).

<a id="phones-types"></a>

## Tipos de Telefones

**Menu:** Parametrização. **Caminho relativo:** `/phones-types`.

Classificar os telefones das pessoas.

**Como usar.** Cadastre uma descrição e utilize-a no campo Tipo de Telefone.

**Regras e efeitos.** A descrição é obrigatória. As opções são compartilhadas pelos cadastros de telefone.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Descrição | `description` | Texto | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Descrição. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [PhoneTypeController.php](../../../app/Http/Controllers/PhoneType/PhoneTypeController.php), [index.blade.php](../../../resources/views/phones-types/index.blade.php), [PhoneTypeRequest.php](../../../app/Http/Requests/PhoneTypeRequest.php).

<a id="relationships-degrees"></a>

## Graus Relacionamento

**Menu:** Parametrização. **Caminho relativo:** `/relationships-degrees`.

Manter os graus de relacionamento dos dependentes.

**Como usar.** Cadastre o nome e selecione-o ao incluir um dependente.

**Regras e efeitos.** É um catálogo de dependentes; não define a hierarquia de aprovação da equipe.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Descrição. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [RelationshipDegreeController.php](../../../app/Http/Controllers/RelationshipDegree/RelationshipDegreeController.php), [index.blade.php](../../../resources/views/relationships-degrees/index.blade.php), [RelationshipDegreeRequest.php](../../../app/Http/Requests/RelationshipDegreeRequest.php).

<a id="authorizations-types"></a>

## Tipos de Autorização

**Menu:** Parametrização. **Caminho relativo:** `/authorizations-types`.

Definir a quantidade de respostas necessária para decidir cada tipo de autorização.

**Como usar.** Abra um tipo existente e escolha a quantidade de aprovações; salve.

**Regras e efeitos.** A rotina distingue todos os responsáveis ou uma aprovação. Uma recusa registrada resulta em negativa na consolidação. A tela oferece manutenção de tipos existentes, sem cadastro ou exclusão normal no menu.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Não marcado |
| Qtd. de Aprovações | `approval` | Opção | Não marcado |

**Ações apresentadas:** Salvar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, Qtd. Aprovações. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [AuthorizationTypeController.php](../../../app/Http/Controllers/Authorization/AuthorizationTypeController.php), [index.blade.php](../../../resources/views/authorizations-types/index.blade.php), [AuthorizationTypeRequest.php](../../../app/Http/Requests/AuthorizationTypeRequest.php).

<a id="categories"></a>

## Categorias

**Menu:** Parametrização. **Caminho relativo:** `/categories`.

Classificar as despesas e restringir sua disponibilidade por usuário.

**Como usar.** Informe nome, abreviação, tipo e os usuários que podem utilizar a categoria; cadastre ou salve.

**Regras e efeitos.** Sem usuários vinculados, a categoria fica visível para todos. Com vínculos, aparece no lançamento de despesas apenas para os usuários selecionados. O tipo Despesa é usado nos lançamentos e descontos.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |
| Nome Abreviado | `short_name` | Texto | Não marcado |
| Tipo | `id_category_type` | Seleção | Sim |
| Usuários | `users` | Seleção múltipla | Não marcado |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, Nome Abreviado, Tipo. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [CategoryController.php](../../../app/Http/Controllers/Category/CategoryController.php), [index.blade.php](../../../resources/views/categories/index.blade.php), [CategoryRequest.php](../../../app/Http/Requests/CategoryRequest.php).

<a id="discounts"></a>

## Descontos

**Menu:** Parametrização. **Caminho relativo:** `/discounts`.

Definir os descontos aplicáveis às categorias de despesa.

**Como usar.** Cadastre nome e tipos de despesa. Depois cadastre os valores com vigência e vincule o desconto às pessoas.

**Regras e efeitos.** A regra depende de três cadastros: desconto/categorias, valor por data e desconto da pessoa. Só cadastrar o nome não produz abatimento.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |
| Tipos de Despesa | `id_category` | Seleção múltipla | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, Tipos de Despesa. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [DiscountController.php](../../../app/Http/Controllers/Discount/DiscountController.php), [index.blade.php](../../../resources/views/discounts/index.blade.php), [DiscountRequest.php](../../../app/Http/Requests/DiscountRequest.php).

<a id="discounts-amounts"></a>

## Valores Descontos

**Menu:** Parametrização. **Caminho relativo:** `/discounts/{pid}/amounts`.

Manter a evolução dos valores de um desconto.

**Como usar.** Selecione o desconto, informe data inicial e valor; cadastre. Para alterar um valor existente, abra a linha correspondente.

**Regras e efeitos.** Não pode haver duas vigências com a mesma data para o mesmo desconto. No cálculo é usado o valor cuja data seja a mais recente não posterior à data da despesa. Sem vigência anterior ou igual, o valor aplicado é zero.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data | `date` | Data | Sim |
| Valor | `amount` | Valor monetário | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, Tipos de Despesa, Data, Valor. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [DiscountAmountController.php](../../../app/Http/Controllers/Discount/DiscountAmountController.php), [parent.blade.php](../../../resources/views/discounts/amounts/parent.blade.php), [index.blade.php](../../../resources/views/discounts/amounts/index.blade.php), [DiscountAmountRequest.php](../../../app/Http/Requests/DiscountAmountRequest.php).
