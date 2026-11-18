# ERP View

Sistema de gestão com cadastro de pessoas e equipes, permissões por sistema e perfil, autorizações, despesas com rateios, adiantamentos, devoluções, lotes, conferência financeira, registro de pagamentos, consultas e relatórios.

## Documentação

O [Manual do ERP View](docs/manual/README.md) explica as telas e os fluxos operacionais para colaboradores, responsáveis pelas autorizações, financeiro e administradores.

| Conteúdo | Acesso |
|---|---|
| Catálogo completo de telas e caminhos | [Inventário](docs/manual/inventario.md) |
| Login, navegação, autorizações pessoais e Meus Lotes | [Uso geral](docs/manual/telas/01-acesso-dashboard.md) |
| Sistemas, usuários, perfis e permissões | [Acessos](docs/manual/telas/02-sistemas-acessos.md) |
| Clientes, calendário, categorias, descontos e configurações | [Parametrização](docs/manual/telas/03-parametrizacao.md) |
| Pessoas, equipe e históricos | [Pessoas](docs/manual/telas/04-pessoas.md) |
| Telas operacionais de despesas e financeiro | [Despesas e financeiro](docs/manual/telas/05-despesas-financeiro.md) |
| Consultas, simulador e relatórios | [Análise](docs/manual/telas/06-consultas-relatorios.md) |
| E-mails e tarefas agendadas | [Monitoramento](docs/manual/telas/07-monitoramento.md) |
| Solicitar, aprovar, compensar e devolver adiantamento | [Fluxo de adiantamentos](docs/manual/fluxos/adiantamentos.md) |
| Solicitar despesas, ratear, gerar lote e conferir | [Fluxo de despesas e lotes](docs/manual/fluxos/despesas-lotes.md) |
| Descontos, saldo utilizado e valor pago | [Fluxo de pagamentos](docs/manual/fluxos/pagamentos.md) |
| Preparar pessoas e responsáveis | [Fluxo de acessos](docs/manual/fluxos/acessos.md) |
| Eventos e destinatários de e-mail | [Comunicações](docs/manual/operacao/notificacoes.md) |
| Agenda diária, encerramentos, limpeza e backup | [Rotinas](docs/manual/operacao/rotinas.md) |
| Mensagens, divergências e recursos ainda ausentes | [Dúvidas](docs/manual/operacao/duvidas.md) |

## Base documentada

O manual foi revisado nos fontes de `main`, commit `c80a8d0737d60c9dedbf79391c8232f3e324c28c`, em 18/11/2026. Contém as 55 entradas de menu do catálogo e as páginas fixas. Não substitui a validação da configuração e dos dados da instalação em produção.

Nesta revisão, as páginas operacionais são montadas sob o nome URL do sistema selecionado. Alterações existentes em outra branch, como `intra`, não devem ser presumidas na `main`. O cadastro de rotas e permissões também depende dos dados da instalação.

## Organização dos fontes

| Local | Responsabilidade |
|---|---|
| `app/Http/Controllers` | Ações das telas e consultas |
| `app/Http/Requests` | Validações de entrada |
| `app/Models` | Entidades, relacionamentos, filtros e situações |
| `app/Helpers` | Cálculos e regras compartilhadas |
| `resources/views` | Formulários, listagens, relatórios e PDF de lote |
| `app/Notifications` e `app/Listeners` | Comunicações e registros de eventos |
| `app/Console/Kernel.php` e `app/Console/Commands` | Agenda e tarefas automáticas |
| `database/migrations` e `database/seeders` | Estrutura e cadastros de base |
| `docs/manual` | Manual funcional das telas e fluxos |

Ao modificar uma rotina, atualize o capítulo da tela, o fluxo correspondente e o inventário. Registre limitações verificadas como limitações, sem apresentar comportamentos planejados como já implementados.
