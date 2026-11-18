# Rotinas automáticas, parâmetros e suporte

[Voltar ao manual](../README.md) · [Monitoramento](../telas/07-monitoramento.md)

## Agenda diária

A aplicação está configurada com o fuso **America/Sao_Paulo**. Os horários abaixo são os definidos no código, não confirmação de execução no servidor. O agendador precisa ser acionado regularmente pela infraestrutura para executar as tarefas no minuto devido.

| Horário | Rotina | Critério e efeito |
|---|---|---|
| 00h00 | Encerrar autorizações | Torna inativas as autorizações ativas elegíveis pelo prazo e pela ausência de respostas recentes |
| 00h00 | Encerrar lotes sem reembolso | Fecha lotes ativos com total reembolsável zero e criação anterior ao prazo configurado |
| 00h30 | Remover despesas inativas | Exclui despesas sem lote cuja autorização esteja inativa |
| 00h30 | E-mail de lotes pendentes | Tenta avisar inscritos em Revisão de Lotes quando há pendências de revisão inicial ou pagamento |
| 01h00 | Ajustar aprovação de lotes encerrados | Marca a revisão de todos os lotes inativos como aprovada |
| 01h30 | Apagar arquivos de despesas sem vínculo | Remove arquivos do tipo `expenses` que não estão associados a nenhuma despesa |
| 03h00 | Aplicar migrations | Executa migrations pendentes com confirmação forçada |
| 03h00 | Executar seeders | Atualiza os cadastros definidos no conjunto de seeders |
| 04h00 | Remover logs antigos | Exclui registros de tarefas criados há mais de 60 dias |
| 23h00 | Backup | Executa a limpeza de backups e tenta gerar backup somente do banco de dados |

Comandos, na mesma ordem de finalidade: `task:close_authorizations`, `task:close_batches_without_refund`, `task:remove_inactive_expenses`, `task:email_pending_batches`, `task:batch_approved_when_paid`, `task:delete_excess_files`, `task:migrate`, `task:seed`, `task:remove_old_logs`, `task:backup`.

## Encerramento de autorizações

O prazo padrão inicial é 30 dias. A seleção da tarefa considera autorizações ativas cujo fim do período e criação sejam anteriores ao limite. Respostas criadas ou atualizadas dentro do período recente impedem o enquadramento naquela execução.

A rotina marca a autorização como inativa; não apaga seu registro. Entretanto, a tarefa posterior de despesas remove os lançamentos sem lote associados a autorizações inativas. Gere os lotes enquanto a autorização permitir a operação e consulte o suporte quando um fechamento impedir a correção de um lote.

Além da tarefa diária, a consolidação de resposta possui uma regra própria de inativação quando a diferença em dias entre a data atual e o fim da autorização supera 32. Adiantamentos e devoluções também são inativados para tramitação quando recebem decisão final. Esses critérios não são um único prazo uniforme.

## Fechamento de lotes sem reembolso

O parâmetro inicial é 30 dias. A tarefa seleciona lotes ativos com `refundable_amount = 0` e criação anterior ao prazo e os torna inativos. Ela não exige que o lote tenha sido conferido antes de aplicar esse fechamento.

O rótulo da configuração menciona “gerar lote automático sem reembolso”, mas a implementação encerra lotes já existentes. Não há, nessa tarefa, seleção de despesas soltas para criar lote novo.

A tarefa das 01h00 altera `revised_status` para aprovado em **todos os lotes inativos**, sem exigir data ou valor de pagamento. Seu nome menciona lotes pagos, mas o critério efetivo é estar inativo. Por isso, a situação final isolada não comprova pagamento.

## Limpezas

- **Despesas:** a remoção considera autorização inativa e ausência de lote. Não é apenas limpeza visual da listagem.
- **Arquivos:** a tarefa considera somente arquivos classificados como `expenses` sem vínculo a despesas. Os comprovantes de devolução usam outro tipo e não entram nessa seleção.
- **Logs:** a limpeza de 60 dias atua em `task_logs`; não foi identificada, nessa tarefa, limpeza de `notification_logs`.

## Backup

Apesar da descrição do comando mencionar sistema e banco, a chamada efetiva é `backup:run --only-db`. Portanto, o agendamento documentado não garante backup dos comprovantes ou de todos os arquivos da aplicação.

Destino, retenção e requisitos do processo dependem da configuração de backup e da infraestrutura. A rotina chama a limpeza antes da geração e grava a saída nos detalhes da tarefa. Um texto genérico de “sucesso” no comando não substitui a análise dos detalhes: a implementação captura erros do backup e pode ainda concluir seu registro de execução.

Não há uma tela de download, restauração ou gerenciamento de backups cadastrada no menu desta versão. Não confundir com o módulo de backups de outros projetos.

## Parâmetros de operação

| Tela/campo | Chave interna | Padrão inicial identificado | Efeito |
|---|---|---|---|
| Qtd. dias para encerrar autorização | `authorizations.active.days_to_close` | 30 | Limite da tarefa de encerramento |
| Termo de Consentimento | `authorizations.cash_advance.agreement_terms` | Sem texto inicial obrigatório | Exige aceite no adiantamento quando preenchido; texto é gravado na solicitação |
| Anexo de arquivo obrigatório | `expenses.required.file` | Leitura tem padrão falso quando a chave não existe | Exige comprovante no cadastro/edição de despesas; não altera a exigência da devolução |
| Qtd. dias para gerar lote automático sem reembolso | `batches.active.days_to_close_without_refund` | 30 | Prazo de fechamento de lote existente sem reembolso |
| Qtd. dias padrão para pagamento de lote | `batches.standard_payment_days` | 3 | Dias úteis sugeridos na conferência para a previsão |

Os valores reais podem ter sido alterados na instalação. O calendário considera sábado, domingo e feriados. A sugestão de pagamento usa a filial do conferente; distribuição de despesas e descontos usam a filial associada ao colaborador da despesa.

## Verificar o agendador

Abra **Logs → Tarefas Agendadas**:

1. Confira Início e Término do último acionamento.
2. Confira a última execução de cada tarefa por sua chave e descrição.
3. Abra **Detalhes** para ler a saída da rotina.
4. Consulte o histórico completo e compare os horários com a agenda diária.
5. Encaminhe ao suporte tarefas sem término, com erro nos detalhes ou sem execução esperada.

As chaves `cron.run.start` e `cron.run.end` são atualizadas durante a montagem da agenda. Não equivalem, por si sós, ao término de todas as tarefas. A última execução individual e sua saída são a evidência mais específica.

O middleware que executaria o agendador ao navegar existe, mas está comentado na pilha HTTP. Assim, apenas usar o sistema não substitui a configuração de cron do servidor nessa revisão.

<a id="rotas-de-suporte"></a>

## Rotas de suporte fora do menu

Estas entradas existem no código e não são procedimentos cotidianos do colaborador. São descritas para o responsável pela instalação, sem orientação para acioná-las durante a leitura do manual.

| Rota | Comportamento implementado |
|---|---|
| `/schedule` e `/cron/run` | Verificam eventos devidos no horário atual e tentam executar seus comandos; resposta JSON contém hora e resultados |
| `/cron/list` | Exibe a agenda obtida de `schedule:list` em texto |
| `/install` | Pode atualizar os fontes via Git quando configurado; aplica migrations e seeders e limpa caches |
| `/test-mail` | Com depuração habilitada, tenta enviar e-mail de teste para o destino informado |
| `/import-database` | Com depuração habilitada e verificação prevista no código, executa o seeder de migração/importação legado |

A chamada de execução da agenda não roda indiscriminadamente todas as tarefas: testa se cada evento está devido naquele instante. Não foi identificado processamento de recuperação de todas as execuções de dias passados. Uma resposta sem tarefas pode apenas indicar que nenhuma estava devida no momento.

O executor HTTP possui código de chave de concorrência, mas remove essa chave antes de tentar adquiri-la. Portanto, não se documenta exclusão mútua garantida entre chamadas simultâneas. O suporte deve avaliar a configuração efetiva de acionamento.

Instalação e importação podem alterar dados; não são telas de consulta ou de demonstração. A documentação não executou essas rotas.

## Referências da revisão

[Agenda](../../../app/Console/Kernel.php), [fuso](../../../config/app.php), [comandos](../../../app/Console/Commands), [autorização e expiração](../../../app/Models/Authorization.php), [fechamento de lotes](../../../app/Helpers/BatchHelper.php), [rotas](../../../routes/web.php), [executor HTTP](../../../app/Http/Controllers/Data/ScheduleController.php), [instalação](../../../app/Http/Controllers/Data/InstallController.php), [pilha HTTP](../../../app/Http/Kernel.php), [parâmetros iniciais](../../../database/seeders/ConfigSeeder.php), [backup](../../../config/backup.php).
