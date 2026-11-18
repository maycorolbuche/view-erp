# Pessoas e históricos

[Voltar ao manual](../README.md) · [Inventário completo](../inventario.md)

Os caminhos abaixo são relativos ao sistema selecionado; veja a convenção de endereços no guia de acesso.

<a id="users"></a>

## Pessoas

**Menu:** Pessoas. **Caminho relativo:** `/users`.

Cadastrar as pessoas utilizadas nos módulos de pessoal e despesas.

**Como usar.** Informe identificação, e-mail, tipo de recurso, filial e os demais dados. Cadastre e acesse as telas complementares para completar o registro.

**Regras e efeitos.** Nome, e-mail e tipo de recurso são validados no servidor; a filial também é marcada obrigatória na tela. E-mail é único; CPF/CNPJ, RG e PIS, quando informados, têm regras de unicidade, com validação de CPF/CNPJ e PIS. O nome de usuário inicial deriva do e-mail quando não informado. O usuário raiz não pode ser excluído.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |
| E-mail | `email` | E-mail | Sim |
| CPF/CNPJ | `cpf_or_cnpj` | CPF/CNPJ | Não marcado |
| RG | `id_card` | RG | Não marcado |
| PIS/PASEB | `pis` | PIS | Não marcado |
| Dt. Nascimento | `birth_date` | Data | Não marcado |
| Estado Civil | `id_civil_status` | Seleção | Não marcado |
| Tipo de Recurso | `id_employment_type` | Seleção | Sim |
| Filial | `id_branch` | Seleção | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserController.php](../../../app/Http/Controllers/User/UserController.php), [index.blade.php](../../../resources/views/users/index.blade.php), [UserRequest.php](../../../app/Http/Requests/UserRequest.php).

<a id="users-phones"></a>

## Telefones

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/phones`.

Manter vários telefones para uma pessoa.

**Como usar.** Selecione a pessoa, informe telefone, operadora, tipo e contato; indique se é comercial e se possui WhatsApp.

**Regras e efeitos.** Telefone é obrigatório. As marcações são informações cadastrais; esta tela não envia WhatsApp. Cada telefone pode ser alterado ou excluído individualmente.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Telefone | `phone` | Telefone | Sim |
| Operadora | `id_carrier` | Seleção | Não marcado |
| Tipo de Telefone | `id_phone_type` | Seleção | Não marcado |
| Contato | `contact_name` | Texto | Não marcado |
| Telefone comercial? | `is_business` | Sim/Não | Não marcado |
| Tem Whatsapp? | `has_whatsapp` | Sim/Não | Não marcado |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial, Número, Operadora, Tipo, Contato. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserPhoneController.php](../../../app/Http/Controllers/User/UserPhoneController.php), [parent.blade.php](../../../resources/views/users/phones/parent.blade.php), [index.blade.php](../../../resources/views/users/phones/index.blade.php), [UserPhoneRequest.php](../../../app/Http/Requests/UserPhoneRequest.php).

<a id="users-address"></a>

## Endereços

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/address`.

Manter o endereço principal da pessoa.

**Como usar.** Selecione a pessoa, preencha CEP, endereço, número, complemento, bairro, cidade e estado e salve.

**Regras e efeitos.** Atualiza o registro da pessoa; não cria uma lista de vários endereços. Esta tela não faz movimentação financeira.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| CEP | `zip_code` | CEP | Não marcado |
| Endereço | `address` | Texto | Não marcado |
| Nº | `number` | Texto | Não marcado |
| Complemento | `complement` | Texto | Não marcado |
| Bairro | `district` | Texto | Não marcado |
| Cidade | `city` | Texto | Não marcado |
| Estado | `state` | Texto | Não marcado |

**Ações apresentadas:** Salvar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserAddressController.php](../../../app/Http/Controllers/User/UserAddressController.php), [parent.blade.php](../../../resources/views/users/address/parent.blade.php), [index.blade.php](../../../resources/views/users/address/index.blade.php), [UserAddressRequest.php](../../../app/Http/Requests/UserAddressRequest.php).

<a id="users-teams"></a>

## Equipe

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/teams`.

Definir relações entre responsáveis e subordinados e quem pode aprovar solicitações.

**Como usar.** Selecione a pessoa, escolha outra pessoa, indique o relacionamento e marque os tipos de autorização sob responsabilidade desse vínculo.

**Regras e efeitos.** A própria pessoa não pode ser vinculada a si mesma; relações repetidas na mesma direção são bloqueadas. O responsável superior aprova os tipos selecionados para o subordinado. Ao alterar os tipos, os vínculos de autorização da relação são recriados.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Pessoa | `id_user_people` | Seleção | Sim |
| Tipo de Relacionamento | `relationship` | Opção | Sim |
| Autorizações | `id_authorization_type` | Marcação | Não marcado |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial, Tipo de Relacionamento, Autorizações. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserTeamController.php](../../../app/Http/Controllers/User/UserTeamController.php), [parent.blade.php](../../../resources/views/users/teams/parent.blade.php), [index.blade.php](../../../resources/views/users/teams/index.blade.php), [UserTeamRequest.php](../../../app/Http/Requests/UserTeamRequest.php).

<a id="users-dependents"></a>

## Dependentes

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/dependents`.

Manter os dependentes de uma pessoa.

**Como usar.** Selecione a pessoa, cadastre nome, grau de relacionamento e data de nascimento do dependente.

**Regras e efeitos.** Nome é obrigatório. Os registros ficam vinculados à pessoa selecionada; não criam contas de acesso ao ERP.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |
| Grau de Relacionamento | `id_relationship_degree` | Seleção | Não marcado |
| Dt. Nascimento | `birth_date` | Data | Não marcado |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial, Grau de Relacionamento, Dt. Nascimento. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserDependentController.php](../../../app/Http/Controllers/User/UserDependentController.php), [parent.blade.php](../../../resources/views/users/dependents/parent.blade.php), [index.blade.php](../../../resources/views/users/dependents/index.blade.php), [UserDependentRequest.php](../../../app/Http/Requests/UserDependentRequest.php).

<a id="users-admission"></a>

## Admissão/Sociedade

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/admission`.

Registrar início, saída e observações do vínculo profissional/societário.

**Como usar.** Selecione a pessoa, informe as datas de início e saída e observações; salve.

**Regras e efeitos.** São dados do cadastro; informar data de saída não equivale ao comando de inativação de login em Usuários.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data de Início | `hire_date` | Data | Não marcado |
| Data de Saída | `termination_date` | Data | Não marcado |
| Anotações/Observações | `admission_notes` | Texto longo | Não marcado |

**Ações apresentadas:** Salvar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserAdmissionController.php](../../../app/Http/Controllers/User/UserAdmissionController.php), [parent.blade.php](../../../resources/views/users/admission/parent.blade.php), [index.blade.php](../../../resources/views/users/admission/index.blade.php), [UserAdmissionRequest.php](../../../app/Http/Requests/UserAdmissionRequest.php).

<a id="users-roles"></a>

## Cargos/Funções

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/roles`.

Registrar o histórico de cargos e funções de uma pessoa.

**Como usar.** Selecione a pessoa, escolha um cargo e informe início e término do período.

**Regras e efeitos.** Cargo é obrigatório. O histórico de cargo não concede permissões nem define aprovadores de despesas.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Cargo | `id_role` | Seleção | Sim |
| Dt. Início | `start_date` | Data | Não marcado |
| Dt. Término | `end_date` | Data | Não marcado |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial, Cargo, Dt. Início, Dt. Término. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserRoleController.php](../../../app/Http/Controllers/User/UserRoleController.php), [parent.blade.php](../../../resources/views/users/roles/parent.blade.php), [index.blade.php](../../../resources/views/users/roles/index.blade.php), [UserRoleRequest.php](../../../app/Http/Requests/UserRoleRequest.php).

<a id="users-vacations"></a>

## Férias

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/vacations`.

Registrar os períodos das férias de uma pessoa.

**Como usar.** Informe os períodos aquisitivo, solicitado, de aprovação, aprovado e efetivo nos grupos apresentados; cadastre ou salve a linha.

**Regras e efeitos.** A tela é de manutenção de histórico. Não foi identificado fluxo separado de solicitação e aprovação de férias com notificações; não confundir os nomes dos períodos com uma aprovação automática.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Dt. Início | `start_date_acquisition_period` | Data | Não marcado |
| Dt. Término | `end_date_acquisition_period` | Data | Não marcado |
| Dt. Início | `start_date_requested_period` | Data | Não marcado |
| Dt. Término | `end_date_requested_period` | Data | Não marcado |
| Dt. Início | `start_date_approval_period` | Data | Não marcado |
| Dt. Término | `end_date_approval_period` | Data | Não marcado |
| Dt. Início | `start_date_approved_period` | Data | Não marcado |
| Dt. Término | `end_date_approved_period` | Data | Não marcado |
| Dt. Início | `start_date` | Data | Não marcado |
| Dt. Término | `end_date` | Data | Não marcado |

Os pares de datas repetidos pertencem, nesta ordem, aos períodos aquisitivo, solicitado, de aprovação, aprovado e efetivo.

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial, Período Gozo, Período Aquisitivo, Período Solicitado, Período de Aprovação, Período Aprovado. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserVacationController.php](../../../app/Http/Controllers/User/UserVacationController.php), [parent.blade.php](../../../resources/views/users/vacations/parent.blade.php), [index.blade.php](../../../resources/views/users/vacations/index.blade.php), [UserVacationRequest.php](../../../app/Http/Requests/UserVacationRequest.php).

<a id="users-payments"></a>

## Pagamentos

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/payments`.

Registrar pagamentos cadastrais da pessoa.

**Como usar.** Selecione a pessoa, informe data, valor e descrição e cadastre; utilize a listagem para alterações.

**Regras e efeitos.** Data e valor são obrigatórios. Este cadastro é separado de Pagamentos de Lotes: não compensa adiantamentos, não fecha lote e não cria a transação financeira de pagamento de lote.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data | `date` | Data | Sim |
| Valor | `amount` | Valor monetário | Sim |
| Descrição | `description` | Texto | Não marcado |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial, Data, Valor, Descrição. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserPaymentController.php](../../../app/Http/Controllers/User/UserPaymentController.php), [parent.blade.php](../../../resources/views/users/payments/parent.blade.php), [index.blade.php](../../../resources/views/users/payments/index.blade.php), [UserPaymentRequest.php](../../../app/Http/Requests/UserPaymentRequest.php).

<a id="users-pension"></a>

## Previdência

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/pension`.

Registrar datas de pagamentos de previdência da pessoa.

**Como usar.** Selecione a pessoa e informe a data a registrar.

**Regras e efeitos.** A data é obrigatória. A tela guarda datas; não calcula contribuições, valores nem pagamentos de lotes.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data | `date` | Data | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial, Data. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserPensionController.php](../../../app/Http/Controllers/User/UserPensionController.php), [parent.blade.php](../../../resources/views/users/pension/parent.blade.php), [index.blade.php](../../../resources/views/users/pension/index.blade.php), [UserPensionRequest.php](../../../app/Http/Requests/UserPensionRequest.php).

<a id="users-certifications"></a>

## Especializações

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/certifications`.

Manter especializações da pessoa.

**Como usar.** Informe data de início, data de término e descrição da especialização.

**Regras e efeitos.** Início e descrição são obrigatórios no servidor. O título interno Lista de Pagamentos desta tela é reaproveitado; os registros são especializações.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data de Início | `start_date` | Data | Sim |
| Data de Término | `end_date` | Data | Não marcado |
| Descrição | `description` | Texto | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial, Data de Início, Data de Término, Descrição. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserCertificationController.php](../../../app/Http/Controllers/User/UserCertificationController.php), [parent.blade.php](../../../resources/views/users/certifications/parent.blade.php), [index.blade.php](../../../resources/views/users/certifications/index.blade.php), [UserCertificationRequest.php](../../../app/Http/Requests/UserCertificationRequest.php).

<a id="users-sick-leaves"></a>

## Atestados

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/sick-leaves`.

Manter os períodos e as descrições dos atestados da pessoa.

**Como usar.** Selecione a pessoa e informe início, término e descrição.

**Regras e efeitos.** Início e descrição são obrigatórios no servidor. Não há campo de arquivo do atestado nesta versão. O título interno Lista de Pagamentos é reaproveitado; não representa pagamentos.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data de Início | `start_date` | Data | Sim |
| Data de Término | `end_date` | Data | Não marcado |
| Descrição | `description` | Texto | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial, Data de Início, Data de Término, Descrição. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserSickLeaveController.php](../../../app/Http/Controllers/User/UserSickLeaveController.php), [parent.blade.php](../../../resources/views/users/sick-leaves/parent.blade.php), [index.blade.php](../../../resources/views/users/sick-leaves/index.blade.php), [UserSickLeaveRequest.php](../../../app/Http/Requests/UserSickLeaveRequest.php).

<a id="users-warnings"></a>

## Advertências

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/warnings`.

Registrar advertências da pessoa.

**Como usar.** Informe data e descrição e cadastre; abra uma linha para corrigir ou excluir.

**Regras e efeitos.** Data e descrição são obrigatórias. O título interno Lista de Pagamentos é reaproveitado; são advertências e não movimentações financeiras.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Data | `date` | Data | Sim |
| Descrição | `description` | Texto | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial, Data, Descrição. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserWarningController.php](../../../app/Http/Controllers/User/UserWarningController.php), [parent.blade.php](../../../resources/views/users/warnings/parent.blade.php), [index.blade.php](../../../resources/views/users/warnings/index.blade.php), [UserWarningRequest.php](../../../app/Http/Requests/UserWarningRequest.php).

<a id="users-discounts"></a>

## Descontos Lote

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/discounts`.

Escolher os descontos que incidirão nos lotes da pessoa.

**Como usar.** Selecione a pessoa, marque os descontos cadastrados e salve.

**Regras e efeitos.** A gravação substitui todos os descontos vinculados à pessoa. O efeito ocorre na geração de novos lotes e depende das categorias e vigências do desconto.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Tipos de Despesa | `id_discount` | Seleção múltipla | Não marcado |

**Ações apresentadas:** Salvar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserDiscountController.php](../../../app/Http/Controllers/User/UserDiscountController.php), [parent.blade.php](../../../resources/views/users/discounts/parent.blade.php), [index.blade.php](../../../resources/views/users/discounts/index.blade.php), [UserDiscountRequest.php](../../../app/Http/Requests/UserDiscountRequest.php).

<a id="users-notifications"></a>

## Notificações

**Menu:** Pessoas. **Caminho relativo:** `/users/{pid}/notifications`.

Definir os avisos operacionais recebidos pela pessoa.

**Como usar.** Selecione a pessoa, marque as notificações disponíveis e salve.

**Regras e efeitos.** O catálogo inicial contém Revisão de Lotes. Vínculos de notificação marcados como obrigatórios são preservados. Esta assinatura é distinta de ser aprovador de uma autorização.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Notificações | `id_notification` | Marcação | Não marcado |

**Ações apresentadas:** Salvar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserNotificationController.php](../../../app/Http/Controllers/User/UserNotificationController.php), [parent.blade.php](../../../resources/views/users/notifications/parent.blade.php), [index.blade.php](../../../resources/views/users/notifications/index.blade.php), [UserNotificationRequest.php](../../../app/Http/Requests/UserNotificationRequest.php).
