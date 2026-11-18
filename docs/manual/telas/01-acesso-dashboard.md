# Acesso, navegação e uso geral

[Voltar ao manual](../README.md)

<a id="login"></a>

## Login

Abra `/login`. Informe **nome de usuário ou e-mail** no campo de identificação e a senha. A opção de lembrar o acesso mantém a autenticação conforme a sessão e o navegador. Confirme a entrada.

O sistema procura a pessoa pelo identificador informado. Se ela não tiver senha cadastrada, encaminha para recuperação de senha para criar uma nova. Contas inativas não conseguem permanecer autenticadas. Credenciais inválidas retornam à tela com mensagem de erro.

A autenticação atualiza a data do último acesso e o contador de acessos por um listener. Em ambiente `local`, existe tratamento que ignora a conferência da senha; isso é comportamento de desenvolvimento e não é o procedimento normal de produção.

<a id="recuperar-senha"></a>

## Recuperar senha

No acesso, utilize a opção de recuperação, ou abra `/password/reset`. Informe o e-mail cadastrado e solicite o link. O envio depende da configuração de e-mail da instalação. Se não receber, confira spam, endereço cadastrado e atendimento do suporte.

<a id="redefinir-senha"></a>

## Redefinir senha

Abra o endereço recebido por e-mail (`/password/reset/{token}`), confirme o e-mail e informe a nova senha e sua confirmação. O link é validado pelo serviço de recuperação de senhas; link vencido ou inválido exige uma nova solicitação. A gravação trata a senha no modelo e altera o token de lembrança do acesso.

<a id="entrada"></a>

## Entrada e seleção de sistema

Depois do login, a raiz `/` examina os sistemas vinculados ao usuário:

| Situação | Resultado |
|---|---|
| Nenhum sistema vinculado | Mensagem de ausência de sistemas; solicitar acesso ao administrador |
| Um sistema vinculado | Redirecionamento direto para seu nome URL |
| Vários sistemas vinculados | Página com as opções disponíveis para escolha |

Ter um sistema vinculado não garante módulos autorizados dentro dele. Para isso, o administrador deve configurar perfis ou acessos diretos.

<a id="dashboard"></a>

## Dashboard

Na página inicial do sistema escolhido, o usuário vê a saudação e orientações de navegação. Os avisos aparecem de acordo com as permissões e a existência de pendências:

| Aviso | Origem da contagem | Próxima ação |
|---|---|---|
| Revisões pendentes | Lotes ativos para revisão, ainda sem responsável de revisão registrado | Revisar Lotes |
| Pagamentos pendentes | Lotes ativos aprovados | Registrar Pagamentos |
| Autorizações pendentes | Solicitações ativas ainda sem decisão final e aguardando a resposta do usuário | Ver Autorizações |
| Sem Módulos Autorizados | Nenhuma entrada de menu liberada ao usuário no sistema | Administrador deve revisar acessos |

A contagem de revisões do dashboard é mais restrita que a fila de conferência: lotes já iniciados podem permanecer na tela de conferência sem entrar nesse aviso.

Não foi identificado, nesta versão da `main`, o módulo de aniversariantes existente em outra linha de desenvolvimento. O manual não o apresenta como recurso dessa revisão.

## Menu, listagens e formulários

O menu é montado a partir dos módulos e operações permitidos ao usuário e aos seus perfis, dentro do sistema escolhido. Financeiro, Consultas e Relatórios podem alcançar dados de vários usuários; telas pessoais aplicam os recortes indicados em seus capítulos.

As listagens mostram paginação, ordenação e pesquisa conforme o componente da tela. Um botão de edição abre o registro no formulário; o botão de consulta abre seus detalhes. Campos e filtros de uma tela não devem ser presumidos em outra. As colunas específicas estão descritas no catálogo de telas.

| Ação padrão | Efeito |
|---|---|
| Cadastrar | Grava um registro novo |
| Cadastrar como Novo | Usa os dados preenchidos para uma inclusão, em vez de substituir o registro aberto; não garante cópia dos históricos vinculados |
| Salvar | Atualiza o registro ou o conjunto de vínculos apresentado |
| Excluir | Solicita confirmação e tenta remover o registro; vínculos de banco e proteções podem impedir a exclusão |
| Cancelar | Volta à lista/destino definido na tela; não desfaz uma operação já gravada |
| Imprimir | Abre o PDF do lote em outra aba, nas telas em que esse recurso existe |

Um botão pode ficar desabilitado por falta de permissão ou não aparecer na etapa atual. A presença de um campo na tela e a validação no servidor são coisas distintas: algumas validações só são mostradas ao enviar o formulário. Se houver erro, corrija o dado indicado e confira se a operação já foi gravada antes de repetir.

Nos cadastros complementares, selecione primeiro a pessoa, desconto, perfil ou sistema. O código desse registro é `{pid}`; o código de uma linha do histórico é `{id}`. Confirme o nome no cabeçalho para não manter dados de outra pessoa.

<a id="senha"></a>

## Alterar a própria senha

Caminho: `/{sistema}/me/password-change`.

Informe **Senha Atual**, **Nova Senha** e **Confirme a Nova Senha**. A nova senha deve ter no mínimo oito caracteres e coincidir com a confirmação. Salve. A senha atual é conferida antes da atualização; se não corresponder, nenhuma nova senha é gravada por essa ação.

Esta é a rotina do usuário autenticado. A manutenção administrativa de credenciais fica em Usuários e Acessos → Usuários.

<a id="autorizacoes"></a>

## Autorizações do usuário e solicitações para responder

Caminho: `/{sistema}/me/authorizations`.

A página reúne pendências e a listagem de autorizações com participação do usuário, seja como solicitante ou como responsável. Abra uma linha para ver tipo, solicitante, data/período, valor quando aplicável, motivo, clientes e respostas dos responsáveis.

Para uma devolução com comprovante, o link do arquivo fica nos detalhes. Registros antigos podem não ter anexo.

Somente o responsável com resposta ainda pendente em solicitação ativa e sem decisão final recebe o formulário de resposta. Escolha **Aprovar/Negar** conforme as opções da tela, preencha o motivo quando negar e salve. A recusa exige motivo. O sistema consolida as respostas de acordo com o tipo de autorização e tenta notificar os envolvidos.

| Situação | Interpretação |
|---|---|
| Pendente/Aguardando | Ainda não foi tomada uma decisão final e a solicitação está ativa |
| Aprovado | A regra de aprovação do tipo foi satisfeita |
| Negado | Uma recusa resultou na negativa da autorização |
| Expirado | Solicitação sem decisão apresentada como inativa; consulte os detalhes e o prazo |

As marcações de resposta individuais e a decisão final são exibidas separadamente. Para compreender o crédito/débito de saldo decorrente, consulte [adiantamentos](../fluxos/adiantamentos.md).

<a id="meus-lotes"></a>

## Meus Lotes

Caminho: `/{sistema}/me/batches`.

Mostra os lotes do usuário autenticado. Abra o lote para ver status, notas da conferência, despesas, comprovantes, rateios, descontos, totais, gráficos por categoria e cliente e, após a baixa, os dados de pagamento.

**Desfazer Lote** aparece para lotes pendentes ou rejeitados. A operação também verifica no servidor que o lote está ativo, ainda não foi aprovado e não está em revisão. Além disso, bloqueia a operação se alguma despesa estiver vinculada a autorização inativa. Quando aceita, remove o lote e libera suas despesas para manutenção, limpando suas marcações de revisão.

Não existe edição direta dos valores do lote nesta página. Para corrigir despesas de um lote rejeitado, desfaça-o quando permitido, corrija os lançamentos e gere um novo lote. A aprovação e o pagamento são feitos nas telas financeiras.

<a id="impressao"></a>

## Formulário/PDF do lote

O botão **Imprimir** existe em Meus Lotes e na consulta geral de Lotes. O link usa o código do lote criptografado. O documento é aberto em PDF A4 com identificação e informações do lote, despesas e resumo financeiro conforme o modelo.

Nesta revisão, a impressão não está condicionada à aprovação da conferência. O gerador procura o lote a partir do link e não faz uma validação de status aprovado. Portanto, um formulário impresso antes do pagamento não é comprovante de pagamento.

Se o lote não for encontrado, o sistema apresenta a página de documento não localizado. Link inválido ou alteração de chave da aplicação deve ser encaminhado ao suporte.

<a id="anexos"></a>

## Anexos e comprovantes

Despesas e devoluções utilizam o cadastro de arquivos do sistema. O link abre o comprovante para consulta. Na devolução, o anexo é obrigatório; na despesa, a exigência depende do parâmetro geral.

Os formatos aceitos nessas telas são JPG/JPEG, PNG e PDF, com limite de 20 MB por arquivo. Os limites de upload do servidor também podem restringir o envio. Imagens podem ser otimizadas pelo armazenamento; mantenha o comprovante legível.

Depois de erro de validação, selecione o arquivo novamente antes de reenviar: o navegador não restaura automaticamente um arquivo escolhido. As solicitações de devolução não oferecem edição posterior pelo colaborador.

<a id="icones"></a>

## Seletor de ícones

A página auxiliar `/data/icons` dá suporte à escolha de ícones usada no cadastro de Sistemas. Não altera valores financeiros ou acessos por conta própria; o ícone é gravado quando o cadastro principal é salvo.

<a id="saida"></a>

## Sair

Utilize a ação de saída do sistema (`/logout`). Ela encerra a autenticação e redireciona conforme a rotina de logout. Para entrar com outra pessoa, realize nova autenticação.

## Referências da revisão

[Rotas](../../../routes/web.php), [entrada/dashboard](../../../app/Http/Controllers/HomeController.php), [login](../../../app/Http/Controllers/Auth/LoginController.php), [alteração de senha](../../../app/Http/Controllers/Auth/PasswordChangeController.php), [autorizações](../../../app/Http/Controllers/Me/AuthorizationController.php), [Meus Lotes](../../../app/Http/Controllers/Me/BatchController.php), [PDF](../../../app/Http/Controllers/PdfController.php), [botões](../../../app/View/Components/Button.php), [eventos](../../../app/Providers/EventServiceProvider.php).
