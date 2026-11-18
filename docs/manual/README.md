# Manual do ERP View

Manual das telas, regras operacionais e fluxos do sistema, destinado a colaboradores, responsáveis por autorizações, financeiro e administradores.

**Base da documentação:** branch `main`, commit [`c80a8d0737d60c9dedbf79391c8232f3e324c28c`](https://github.com/maycorolbuche/view-erp/commit/c80a8d0737d60c9dedbf79391c8232f3e324c28c), revisado em **18/11/2026**. As instruções descrevem o código dessa revisão. Os dados, rótulos e permissões cadastrados em cada instalação podem mudar o menu efetivamente disponível.

## Comece por aqui

| O que você precisa fazer | Onde consultar |
|---|---|
| Entrar, recuperar senha, entender os botões ou acompanhar pendências | [Acesso e uso geral](telas/01-acesso-dashboard.md) |
| Encontrar uma tela pelo nome ou caminho | [Inventário completo de telas](inventario.md) |
| Cadastrar sistemas, usuários, perfis e permissões | [Sistemas e acessos](telas/02-sistemas-acessos.md) |
| Manter clientes, filiais, categorias, descontos, feriados e parâmetros | [Parametrização](telas/03-parametrizacao.md) |
| Cadastrar pessoas, equipe, dependentes e históricos | [Pessoas](telas/04-pessoas.md) |
| Solicitar despesas/adiantamentos, devolver saldo, gerar, conferir e pagar lotes | [Despesas e financeiro](telas/05-despesas-financeiro.md) |
| Consultar despesas, autorizações, lotes, simulador e relatórios | [Consultas e relatórios](telas/06-consultas-relatorios.md) |
| Ver os e-mails enviados e as execuções das tarefas | [Monitoramento](telas/07-monitoramento.md) |
| Entender a sequência completa de adiantamento e devolução | [Fluxo de adiantamentos](fluxos/adiantamentos.md) |
| Entender autorização de despesa, rateio, lote, revisão e correção | [Fluxo de despesas e lotes](fluxos/despesas-lotes.md) |
| Entender descontos, compensação de saldo e valor pago | [Fluxo de pagamentos e cálculos](fluxos/pagamentos.md) |
| Preparar um usuário e seus aprovadores | [Fluxo de implantação e acessos](fluxos/acessos.md) |
| Entender notificações e destinatários | [Comunicações](operacao/notificacoes.md) |
| Entender cron, fechamentos, limpeza, backup e suporte | [Rotinas automáticas](operacao/rotinas.md) |
| Resolver uma dificuldade ou interpretar uma divergência | [Dúvidas e limites atuais](operacao/duvidas.md) |

## Responsabilidades

| Papel operacional | Responsabilidade | Preparação necessária |
|---|---|---|
| Colaborador | Solicitar autorizações, registrar despesas, gerar lotes, solicitar e devolver adiantamentos | Pessoa ativa, acesso ao sistema e às telas; responsáveis configurados na equipe |
| Responsável pela autorização | Analisar e responder às solicitações atribuídas | Relação de equipe e tipos de autorização habilitados |
| Conferente financeiro | Conferir comprovantes e despesas, reprovar ou aprovar lotes | Acesso e permissão de alteração em Conferência de Lotes |
| Financeiro de pagamentos | Registrar baixa de lote e ajustes de saldo | Acesso e permissão nas telas financeiras correspondentes |
| Administrador | Manter cadastros, calendário, acessos e parâmetros | Permissões administrativas do sistema |
| Suporte | Verificar implantação, e-mail, agendador, erros e backup | Acesso operacional à infraestrutura e aos logs |

Esses papéis explicam as atividades. Não são nomes fixos de perfis obrigatoriamente existentes na instalação. Um mesmo usuário pode acumular papéis conforme suas permissões.

## Conceitos usados no manual

| Termo | Significado |
|---|---|
| Sistema | Área selecionada na entrada, identificada pelo nome URL; delimita navegação e permissões |
| Pessoa/usuário/colaborador | Cadastro central utilizado em autenticação, equipe, despesas e históricos |
| Autorização | Solicitação submetida aos responsáveis; pode ser de despesa, adiantamento ou devolução |
| Despesa | Lançamento de gasto associado a autorização, categoria, forma de pagamento e rateios |
| Rateio por cliente | Distribuição do custo da despesa entre os clientes autorizados |
| Rateio por usuário | Distribuição do custo entre os usuários beneficiados; distinto de quem cadastrou a despesa |
| Lote | Agrupamento de despesas para conferência e eventual reembolso |
| Saldo de adiantamento | Valor ainda disponível para compensação com reembolsos ou devolução |
| Reembolso líquido | Parcela reembolsável do lote menos os descontos calculados na geração |
| Valor pago | Parcela do reembolso líquido que sobra após a compensação do adiantamento |
| Transação | Entrada ou saída registrada no fluxo de caixa |
| Histórico de saldo | Registro das alterações do adiantamento; não equivale a um extrato de todos os lotes |

## Convenção de endereços

Na revisão documentada, as telas do catálogo são montadas sob `/{sistema}`. Por exemplo, o caminho relativo `/expenses` representa `/{sistema}/expenses`, e `/users/{pid}/phones` representa `/{sistema}/users/{codigo-da-pessoa}/phones`. Prefira abrir pelo menu, pois o nome URL do sistema depende do cadastro da instalação.

As rotas de login, recuperação de senha, seleção inicial e arquivos têm regras próprias, descritas no guia de acesso. A existência de uma branch com rotas na raiz não significa que esse desenho esteja ativo na `main` documentada.

## Alcance e atualização

O manual cobre as **55 entradas de menu** cadastradas em `RouteSeeder`, as páginas fixas, os fluxos financeiros, as comunicações e as rotinas automáticas. Inclui campos, ações, validações, efeitos e restrições, com referências ao código para manutenção.

A revisão foi feita nos fontes, sem sessão autenticada de produção. Funcionalidades propostas — como extrato unificado, uma fila financeira específica para validar depósitos e impressão bloqueada antes da aprovação — não são descritas como disponíveis quando ausentes do código.

Ao alterar uma tela ou regra, atualize seu capítulo, o fluxo correspondente e o [inventário](inventario.md). Mudanças de parâmetros devem ser confrontadas também com as [rotinas automáticas](operacao/rotinas.md).
