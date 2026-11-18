# Sistemas, usuários e acessos

[Voltar ao manual](../README.md) · [Inventário completo](../inventario.md)

Os caminhos abaixo são relativos ao sistema selecionado; veja a convenção de endereços no guia de acesso.

<a id="systems"></a>

## Sistemas

**Menu:** Sistemas. **Caminho relativo:** `/systems`.

Cadastrar os sistemas disponíveis na entrada do ERP.

**Como usar.** Preencha nome, ícone e nome URL; cadastre e depois habilite seus módulos em Acessos Sistemas.

**Regras e efeitos.** O nome URL é normalizado para um slug e compõe o endereço das telas. O sistema raiz não pode ser excluído. O nome URL deve ser único; `data`, `logout`, `login` e `password` são reservados pela validação. Não confundir sistema com perfil de acesso.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |
| Ícone | `icon` | Ícone | Sim |
| Nome URL | `slug` | Nome URL | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, Ícone, Nome URL. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [SystemController.php](../../../app/Http/Controllers/System/SystemController.php), [index.blade.php](../../../resources/views/systems/index.blade.php), [SystemRequest.php](../../../app/Http/Requests/SystemRequest.php).

<a id="systems-permissions"></a>

## Acessos Sistemas

**Menu:** Sistemas. **Caminho relativo:** `/systems/{pid}/permissions`.

Definir quais módulos e operações um sistema oferece.

**Como usar.** Selecione o sistema na listagem inicial. Marque os módulos e, quando disponíveis, cadastrar, alterar e excluir; salve.

**Regras e efeitos.** A seleção é substituída ao salvar. Estas permissões delimitam as opções oferecidas às permissões de perfis e usuários. A manutenção também recompõe os acessos raiz.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Ações apresentadas:** Salvar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, Ícone, Nome URL. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [SystemPermissionController.php](../../../app/Http/Controllers/System/SystemPermissionController.php), [parent.blade.php](../../../resources/views/systems/permissions/parent.blade.php), [index.blade.php](../../../resources/views/systems/permissions/index.blade.php).

<a id="users-access"></a>

## Usuários

**Menu:** Usuários e Acessos. **Caminho relativo:** `/users/{pid}/access`.

Manter os dados de autenticação e a situação de acesso da pessoa.

**Como usar.** Selecione a pessoa, confira e-mail, nome de usuário, senha e Usuário Ativo; salve.

**Regras e efeitos.** E-mail válido e nome de usuário são obrigatórios. Não é permitido inativar o usuário raiz por esta rotina. A senha passa pelo tratamento do modelo; não é exibida em texto recuperável. A tela orienta deixar senha em branco para não alterar, mas o controlador não descarta explicitamente esse campo vazio antes do tratamento do modelo; a preservação da senha deve ser conferida pelo suporte nessa revisão. Acesso ao sistema e aos módulos exige vínculos adicionais.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| E-mail | `email` | E-mail | Sim |
| Nome de Usuário | `username` | Texto | Sim |
| Senha | `password` | Texto | Não marcado |
| Usuário Ativo | `active` | Sim/Não | Não marcado |

**Ações apresentadas:** Salvar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserAccessController.php](../../../app/Http/Controllers/User/UserAccessController.php), [parent.blade.php](../../../resources/views/users/access/parent.blade.php), [index.blade.php](../../../resources/views/users/access/index.blade.php), [UserAccessRequest.php](../../../app/Http/Requests/UserAccessRequest.php).

<a id="users-systems"></a>

## Sistemas Usuários

**Menu:** Usuários e Acessos. **Caminho relativo:** `/users/{pid}/systems`.

Escolher os sistemas nos quais uma pessoa pode entrar.

**Como usar.** Selecione a pessoa, marque os sistemas autorizados e salve.

**Regras e efeitos.** Sem sistema, a pessoa não entra em nenhum módulo após o login. A manutenção do usuário raiz é protegida. Salvar substitui os vínculos de sistemas do usuário; conceder sistema não concede automaticamente todos os seus módulos.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Ações apresentadas:** Salvar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserSystemController.php](../../../app/Http/Controllers/User/UserSystemController.php), [parent.blade.php](../../../resources/views/users/systems/parent.blade.php), [index.blade.php](../../../resources/views/users/systems/index.blade.php).

<a id="users-profiles"></a>

## Perfis Usuários

**Menu:** Usuários e Acessos. **Caminho relativo:** `/users/{pid}/profiles`.

Associar perfis à pessoa no sistema em uso.

**Como usar.** Selecione a pessoa, confira se tem acesso ao sistema atual, marque os perfis e salve.

**Regras e efeitos.** A lista de perfis é do sistema atual. A gravação substitui os vínculos de perfis daquele sistema. As permissões desses perfis passam a compor os acessos do usuário.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Ações apresentadas:** Salvar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserProfileController.php](../../../app/Http/Controllers/User/UserProfileController.php), [parent.blade.php](../../../resources/views/users/profiles/parent.blade.php), [index.blade.php](../../../resources/views/users/profiles/index.blade.php).

<a id="users-permissions"></a>

## Acessos Usuários

**Menu:** Usuários e Acessos. **Caminho relativo:** `/users/{pid}/permissions`.

Conceder acessos diretos a uma pessoa e consultar os herdados de perfis.

**Como usar.** Selecione a pessoa e marque os módulos e operações diretas. Confira as permissões de perfil indicadas antes de salvar.

**Regras e efeitos.** A gravação substitui as permissões diretas no sistema atual. Desmarcar um acesso direto não elimina um acesso concedido por perfil; revise também os perfis. A aplicação combina permissões diretas e herdadas.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Ações apresentadas:** Salvar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome, E-mail, Filial. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [UserPermissionController.php](../../../app/Http/Controllers/User/UserPermissionController.php), [parent.blade.php](../../../resources/views/users/permissions/parent.blade.php), [index.blade.php](../../../resources/views/users/permissions/index.blade.php).

<a id="profiles"></a>

## Perfis

**Menu:** Usuários e Acessos. **Caminho relativo:** `/profiles`.

Agrupar permissões em perfis reutilizáveis.

**Como usar.** Cadastre o nome do perfil no sistema atual e configure seus módulos em Acessos Perfis.

**Regras e efeitos.** Perfis são associados a um sistema. O perfil raiz tem proteção contra exclusão. Criar um perfil não o vincula automaticamente às pessoas.

**Campos do formulário e dos filtros.** A obrigatoriedade abaixo reproduz a marcação visual. Campos podem aparecer somente na inclusão, na edição ou em uma etapa específica. As validações adicionais estão nas regras acima.

| Campo | Identificador | Entrada | Obrigatório na tela |
|---|---|---|---|
| Nome | `name` | Texto | Sim |

**Ações apresentadas:** Cadastrar, Cadastrar como Novo, Salvar, Excluir, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [ProfileController.php](../../../app/Http/Controllers/Profile/ProfileController.php), [index.blade.php](../../../resources/views/profiles/index.blade.php), [ProfileRequest.php](../../../app/Http/Requests/ProfileRequest.php).

<a id="profiles-permissions"></a>

## Acessos Perfis

**Menu:** Usuários e Acessos. **Caminho relativo:** `/profiles/{pid}/permissions`.

Definir os módulos e operações permitidos a um perfil.

**Como usar.** Selecione o perfil, marque os acessos e as operações disponíveis e salve.

**Regras e efeitos.** A seleção substitui as permissões do perfil no sistema atual e afeta quem utiliza esse perfil. O catálogo de módulos vem dos acessos habilitados para o sistema.

**Seleção inicial.** Sem uma pessoa, perfil, sistema ou desconto selecionado, a primeira tela mostra a lista para escolha. O formulário de manutenção pertence ao registro escolhido (`{pid}`); quando há histórico, cada linha tem seu próprio código (`{id}`).

**Ações apresentadas:** Salvar, Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Nome. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Referência de conferência:** [ProfilePermissionController.php](../../../app/Http/Controllers/Profile/ProfilePermissionController.php), [parent.blade.php](../../../resources/views/profiles/permissions/parent.blade.php), [index.blade.php](../../../resources/views/profiles/permissions/index.blade.php).
