# Fluxo de preparação de pessoas, acessos e aprovadores

[Voltar ao manual](../README.md) · [Telas de acesso](../telas/02-sistemas-acessos.md) · [Pessoas](../telas/04-pessoas.md)

## Preparar a estrutura

O administrador deve manter as filiais, tipos de recurso, cargos, clientes, formas de pagamento e categorias necessários. Para o financeiro, também configure calendário de feriados, tipos/regras de autorização, descontos e seus valores por vigência.

Na revisão documentada, a estrutura de navegação é por sistemas. Se o sistema já estiver cadastrado, não é necessário criar outro para cada pessoa ou setor. Perfis são o recurso de agrupamento de permissões.

## Cadastrar uma pessoa

1. Em **Pessoas**, cadastre nome, e-mail, tipo de recurso e filial; informe os documentos e dados complementares disponíveis.
2. Complete telefone, endereço e admissão conforme a necessidade. Os históricos são mantidos nas telas específicas.
3. Em **Usuários e Acessos → Usuários**, confira nome de usuário, e-mail, situação ativa e credencial.
4. Se a pessoa ainda não tiver senha, use o procedimento de recuperação de senha para o e-mail cadastrado.
5. Em **Sistemas Usuários**, conceda acesso ao sistema correto.
6. Em **Perfis Usuários**, associe os perfis desejados para o sistema atual.
7. Quando necessário, complemente em **Acessos Usuários** com permissões diretas.
8. Teste operacionalmente a entrada e os módulos disponíveis com a própria pessoa; um cadastro não equivale à concessão completa de acesso.

## Como as permissões se relacionam

| Camada | Tela responsável | Efeito |
|---|---|---|
| Catálogo de sistemas | Sistemas | Define nome, ícone e nome URL de cada área |
| Módulos do sistema | Acessos Sistemas | Habilita módulos e operações que o sistema oferece |
| Entrada do usuário | Sistemas Usuários | Permite escolher/entrar no sistema |
| Grupo de acessos | Perfis + Acessos Perfis | Define conjunto reutilizável de módulos/operações |
| Associação do grupo | Perfis Usuários | Faz o usuário herdar permissões do perfil |
| Exceção/concessão individual | Acessos Usuários | Acrescenta permissões diretas no sistema |

O acesso a uma página e a permissão de cadastrar, alterar ou excluir são tratados separadamente. Um usuário pode consultar uma tela e ter o botão Salvar desabilitado por não possuir alteração.

Os acessos diretos e os de perfis são combinados. Para remover efetivamente uma permissão, verifique todas as origens; retirar uma marcação direta não revoga o que continua concedido por perfil. Ao salvar matrizes de acesso, os vínculos correspondentes são substituídos pelo conjunto marcado.

Usuários, perfis e sistemas raiz têm proteções específicas e são recompostos pela manutenção de acessos. Não utilize os cadastros de cargo ou equipe como substitutos de permissão de tela.

## Configurar os responsáveis pela autorização

1. Em **Pessoas → Equipe**, selecione o colaborador que fará solicitações.
2. Escolha a pessoa responsável e o relacionamento de superior/responsável conforme a direção exibida na tela.
3. Marque quais tipos de autorização esse responsável analisará: despesas, adiantamento, devolução ou os tipos cadastrados.
4. Salve e confira a relação na equipe.
5. Repita para outros responsáveis e configure em **Tipos de Autorização** se a decisão exige todos ou uma aprovação.

A relação é direcionada: responsável/superior e subordinado/solicitante não são intercambiáveis. É proibido vincular a pessoa a si mesma e repetir uma relação já existente na mesma direção.

A lista de responsáveis é consultada ao criar a solicitação. A ausência de pessoas com o tipo correto bloqueia o envio. Ter permissão no financeiro ou receber notificação de lote não transforma automaticamente alguém em aprovador de adiantamento.

## Configurar os destinatários de lotes

Em **Pessoas → Notificações**, marque **Revisão de Lotes** para os usuários que precisam receber o aviso de novos lotes, de lotes desfeitos e os lembretes de pendências. Vínculos obrigatórios são preservados pela gravação.

Esses destinatários são diferentes dos responsáveis pelas autorizações e do colaborador que receberá avisos de aprovação/pagamento de seu lote.

## Disponibilizar categorias e descontos

Categorias sem usuários vinculados são visíveis para todos; com usuários vinculados, ficam disponíveis aos selecionados no lançamento. Se o colaborador não encontrar uma categoria, confirme o tipo Despesa e os vínculos.

Para desconto no lote, configure as categorias do desconto, seu valor com data de vigência e o vínculo em **Descontos Lote** da pessoa. O cálculo ocorre na geração e respeita o calendário descrito no [fluxo de pagamentos](pagamentos.md).

## Checklist de início de operação

- A pessoa consegue autenticar e selecionar o sistema.
- Os módulos necessários aparecem no menu, com as operações corretas.
- O colaborador tem responsável configurado para cada tipo de solicitação necessário.
- Há clientes, categorias e formas de pagamento adequadas.
- Calendário, filial, prazo de autorização, termo e obrigatoriedade de comprovante foram conferidos.
- Financeiro sabe distinguir conferência, baixa de pagamento, ajuste de saldo e devolução aprovada.
- Os destinatários de comunicação e o agendador foram conferidos pelo suporte.

## Referências da revisão

[Rotas por sistema](../../../routes/web.php), [montagem de acessos](../../../app/Http/Middleware/System.php), [checagem de acesso](../../../app/Http/Middleware/Access.php), [equipe](../../../app/Http/Controllers/User/UserTeamController.php), [perfis do usuário](../../../app/Http/Controllers/User/UserProfileController.php), [notificações do usuário](../../../app/Http/Controllers/User/UserNotificationController.php), [categorias visíveis](../../../app/Models/Category.php).
