# Inventário de cobertura

[Voltar ao manual](README.md)

Revisão: `main`, commit `c80a8d0737d60c9dedbf79391c8232f3e324c28c`, em 18/11/2026. Catálogo estático de 55 entradas de menu de `RouteSeeder`, além das páginas fixas descritas abaixo. O banco de produção pode ter rótulos, permissões e rotas diferentes. Cada tela foi confrontada com seu controlador, formulário e regras de validação quando existentes.

| Grupo | Tela | Caminho relativo | Manual |
|---|---|---|---|
| Sistemas | Sistemas | `/systems` | [systems](telas/02-sistemas-acessos.md#systems) |
| Sistemas | Acessos Sistemas | `/systems/{pid}/permissions` | [systems-permissions](telas/02-sistemas-acessos.md#systems-permissions) |
| Parametrização | Configurações Gerais | `/configs` | [configs](telas/03-parametrizacao.md#configs) |
| Parametrização | Clientes | `/clients` | [clients](telas/03-parametrizacao.md#clients) |
| Parametrização | Filiais | `/branches` | [branches](telas/03-parametrizacao.md#branches) |
| Parametrização | Feriados | `/holidays` | [holidays](telas/03-parametrizacao.md#holidays) |
| Parametrização | Cargos | `/roles` | [roles](telas/03-parametrizacao.md#roles) |
| Parametrização | Estados Civis | `/civil-statuses` | [civil-statuses](telas/03-parametrizacao.md#civil-statuses) |
| Parametrização | Formas de Pagamento | `/payment-methods` | [payment-methods](telas/03-parametrizacao.md#payment-methods) |
| Parametrização | Vínculos Trabalho | `/employment-types` | [employment-types](telas/03-parametrizacao.md#employment-types) |
| Parametrização | Operadoras Telefonia | `/carriers` | [carriers](telas/03-parametrizacao.md#carriers) |
| Parametrização | Tipos de Telefones | `/phones-types` | [phones-types](telas/03-parametrizacao.md#phones-types) |
| Parametrização | Graus Relacionamento | `/relationships-degrees` | [relationships-degrees](telas/03-parametrizacao.md#relationships-degrees) |
| Parametrização | Tipos de Autorização | `/authorizations-types` | [authorizations-types](telas/03-parametrizacao.md#authorizations-types) |
| Parametrização | Categorias | `/categories` | [categories](telas/03-parametrizacao.md#categories) |
| Parametrização | Descontos | `/discounts` | [discounts](telas/03-parametrizacao.md#discounts) |
| Parametrização | Valores Descontos | `/discounts/{pid}/amounts` | [discounts-amounts](telas/03-parametrizacao.md#discounts-amounts) |
| Usuários e Acessos | Usuários | `/users/{pid}/access` | [users-access](telas/02-sistemas-acessos.md#users-access) |
| Usuários e Acessos | Sistemas Usuários | `/users/{pid}/systems` | [users-systems](telas/02-sistemas-acessos.md#users-systems) |
| Usuários e Acessos | Perfis Usuários | `/users/{pid}/profiles` | [users-profiles](telas/02-sistemas-acessos.md#users-profiles) |
| Usuários e Acessos | Acessos Usuários | `/users/{pid}/permissions` | [users-permissions](telas/02-sistemas-acessos.md#users-permissions) |
| Usuários e Acessos | Perfis | `/profiles` | [profiles](telas/02-sistemas-acessos.md#profiles) |
| Usuários e Acessos | Acessos Perfis | `/profiles/{pid}/permissions` | [profiles-permissions](telas/02-sistemas-acessos.md#profiles-permissions) |
| Pessoas | Pessoas | `/users` | [users](telas/04-pessoas.md#users) |
| Pessoas | Telefones | `/users/{pid}/phones` | [users-phones](telas/04-pessoas.md#users-phones) |
| Pessoas | Endereços | `/users/{pid}/address` | [users-address](telas/04-pessoas.md#users-address) |
| Pessoas | Equipe | `/users/{pid}/teams` | [users-teams](telas/04-pessoas.md#users-teams) |
| Pessoas | Dependentes | `/users/{pid}/dependents` | [users-dependents](telas/04-pessoas.md#users-dependents) |
| Pessoas | Admissão/Sociedade | `/users/{pid}/admission` | [users-admission](telas/04-pessoas.md#users-admission) |
| Pessoas | Cargos/Funções | `/users/{pid}/roles` | [users-roles](telas/04-pessoas.md#users-roles) |
| Pessoas | Férias | `/users/{pid}/vacations` | [users-vacations](telas/04-pessoas.md#users-vacations) |
| Pessoas | Pagamentos | `/users/{pid}/payments` | [users-payments](telas/04-pessoas.md#users-payments) |
| Pessoas | Previdência | `/users/{pid}/pension` | [users-pension](telas/04-pessoas.md#users-pension) |
| Pessoas | Especializações | `/users/{pid}/certifications` | [users-certifications](telas/04-pessoas.md#users-certifications) |
| Pessoas | Atestados | `/users/{pid}/sick-leaves` | [users-sick-leaves](telas/04-pessoas.md#users-sick-leaves) |
| Pessoas | Advertências | `/users/{pid}/warnings` | [users-warnings](telas/04-pessoas.md#users-warnings) |
| Pessoas | Descontos Lote | `/users/{pid}/discounts` | [users-discounts](telas/04-pessoas.md#users-discounts) |
| Pessoas | Notificações | `/users/{pid}/notifications` | [users-notifications](telas/04-pessoas.md#users-notifications) |
| Despesas | Solicitação de Despesas | `/authorizations-expenses` | [authorizations-expenses](telas/05-despesas-financeiro.md#authorizations-expenses) |
| Despesas | Cadastro de Despesas | `/expenses` | [expenses](telas/05-despesas-financeiro.md#expenses) |
| Despesas | Solic. Adiantamento | `/authorizations-cash-advances` | [authorizations-cash-advances](telas/05-despesas-financeiro.md#authorizations-cash-advances) |
| Despesas | Dev. Adiantamento | `/authorizations-cash-advance-returns` | [authorizations-cash-advance-returns](telas/05-despesas-financeiro.md#authorizations-cash-advance-returns) |
| Despesas | Gerar Lote | `/batches` | [batches](telas/05-despesas-financeiro.md#batches) |
| Financeiro | Conferência de Lotes | `/batch-review` | [batch-review](telas/05-despesas-financeiro.md#batch-review) |
| Financeiro | Pagamentos de Lotes | `/batch-payments` | [batch-payments](telas/05-despesas-financeiro.md#batch-payments) |
| Financeiro | Adiantamentos | `/cash-advances` | [cash-advances](telas/05-despesas-financeiro.md#cash-advances) |
| Financeiro | Fluxo de Caixa | `/cash-flow` | [cash-flow](telas/05-despesas-financeiro.md#cash-flow) |
| Consultas | Autorizações | `/queries/authorizations` | [queries-authorizations](telas/06-consultas-relatorios.md#queries-authorizations) |
| Consultas | Despesas | `/queries/expenses` | [queries-expenses](telas/06-consultas-relatorios.md#queries-expenses) |
| Consultas | Lotes | `/queries/batches` | [queries-batches](telas/06-consultas-relatorios.md#queries-batches) |
| Relatórios | Por Usuários | `/reports/users` | [reports-users](telas/06-consultas-relatorios.md#reports-users) |
| Relatórios | Por Clientes | `/reports/clients` | [reports-clients](telas/06-consultas-relatorios.md#reports-clients) |
| Relatórios | Por Tipo de Despesas | `/reports/expenses` | [reports-expenses](telas/06-consultas-relatorios.md#reports-expenses) |
| Logs | E-mails | `/logs/notification` | [notification-logs](telas/07-monitoramento.md#notification-logs) |
| Logs | Tarefas Agendadas | `/logs/tasks` | [task-logs](telas/07-monitoramento.md#task-logs) |

## Páginas fora do catálogo de menu

| Página | Caminho | Documentação |
|---|---|---|
| Login | `/login` | [Acesso](telas/01-acesso-dashboard.md#login) |
| Recuperar senha | `/password/reset` | [Acesso](telas/01-acesso-dashboard.md#recuperar-senha) |
| Redefinir senha pelo link | `/password/reset/{token}` | [Acesso](telas/01-acesso-dashboard.md#redefinir-senha) |
| Seleção de sistema | `/` | [Entrada](telas/01-acesso-dashboard.md#entrada) |
| Dashboard do sistema | `/{sistema}` | [Dashboard](telas/01-acesso-dashboard.md#dashboard) |
| Alteração da própria senha | `/{sistema}/me/password-change` | [Senha](telas/01-acesso-dashboard.md#senha) |
| Autorizações próprias/atribuídas | `/{sistema}/me/authorizations` | [Autorizações](telas/01-acesso-dashboard.md#autorizacoes) |
| Meus Lotes | `/{sistema}/me/batches` | [Lotes](telas/01-acesso-dashboard.md#meus-lotes) |
| PDF do lote | `/{sistema}/pdf/batch/{id-criptografado}` | [Impressão](telas/01-acesso-dashboard.md#impressao) |
| Saída | `/logout` | [Acesso](telas/01-acesso-dashboard.md#saida) |
| Arquivo armazenado | `/storage/{path}` | [Anexos](telas/01-acesso-dashboard.md#anexos) |
| Seletor de ícones | `/data/icons` | [Acesso](telas/01-acesso-dashboard.md#icones) |
| Páginas de erro | Conforme a condição | [Problemas frequentes](operacao/duvidas.md) |
| Instalação, cron e diagnóstico | Rotas de suporte | [Rotinas e suporte](operacao/rotinas.md#rotas-de-suporte) |

`Search/UserSearchController` e a view `search/users` existem no código, porém suas rotas de busca estão comentadas em `routes/web.php`. Não são apresentados como uma tela operacional disponível.

## O que foi verificado

- Registro de rotas fixas e montagem dinâmica por sistema; grupos e entradas do menu nos seeders.
- Todos os controladores de telas, formulários Blade, componentes de formulário/listagem e classes de validação do cadastro.
- Regras de autorização, visibilidade, saldo, geração/revisão/pagamento de lote, descontos, dias úteis e rateios.
- Relatórios, consultas, simulador, notificações, listeners de logs, comandos e agenda.
- Estruturas de dados e vínculos usados nas movimentações, para distinguir cadastros de operações financeiras.

## Limites da revisão

Não foi feita navegação autenticada no ambiente de produção, inspeção de seus dados ou confirmação de entregas de e-mail, transferências e execução efetiva do cron. Este manual descreve o comportamento implementado na revisão indicada. Não contém capturas simuladas de telas nem trata funcionalidades propostas como entregues.

O código da branch `intra` não foi mesclado ao conteúdo desta revisão. A existência de uma alteração em outra branch não muda automaticamente o comportamento da `main`.
