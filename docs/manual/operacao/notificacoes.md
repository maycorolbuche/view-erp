# Comunicações e destinatários

[Voltar ao manual](../README.md) · [Monitoramento de e-mails](../telas/07-monitoramento.md#notification-logs)

## Eventos que tentam enviar e-mail

| Evento | Destinatários definidos no fluxo | Conteúdo principal |
|---|---|---|
| Solicitação de despesas | Responsáveis da autorização e solicitante | Tipo, situação, período, motivo, clientes e responsáveis |
| Solicitação de adiantamento | Responsáveis da autorização e solicitante | Tipo, valor, motivo, termo quando existente e responsáveis |
| Cadastro de devolução | Não há chamada automática de envio nesta revisão | O cadastro fica disponível para análise em Autorizações |
| Resposta a uma autorização | Responsáveis da autorização e solicitante | Atualização de situação e respostas individuais |
| Geração de lote | Inscritos em Revisão de Lotes | Novo lote, colaborador, quantidade e resumo financeiro; link do documento |
| Lote desfeito | Inscritos em Revisão de Lotes | Código do lote desfeito |
| Conferência aprovada | Colaborador dono do lote | Aprovação e previsão de pagamento quando aplicável |
| Conferência reprovada | Colaborador dono do lote | Reprovação, responsável e motivo |
| Fechamento sem reembolso | Colaborador dono do lote | Informação de fechamento |
| Baixa de pagamento | Colaborador dono do lote | Informação de pagamento/conclusão conforme a classificação do lote |
| Lembrete de pendências | Inscritos em Revisão de Lotes | Pendências de revisão e pagamento; tarefa diária |
| Recuperação de senha | E-mail cadastrado da pessoa | Link para definir uma nova senha |

Os avisos são tentativas de comunicação. Um envio pode falhar depois de o cadastro, aprovação ou pagamento ter sido gravado. Verifique os registros antes de repetir uma operação financeira.

## Escolher quem recebe os avisos de lote

Abra **Pessoas → Notificações**, escolha a pessoa, marque **Revisão de Lotes** e salve. A associação vem do catálogo de notificações. Ela não substitui a relação de equipe que define responsáveis de autorização.

A geração de lote percorre os destinatários dessa assinatura. O modelo de mensagem tem uma variação de texto para quando o destinatário é o próprio dono do lote, mas isso não garante inclusão automática de todo colaborador no envio.

## Mensagens de autorização

A notificação diferencia o solicitante dos demais responsáveis. Apresenta dados da solicitação, situação geral e uma tabela de respostas com nomes, e-mails, decisões e observações dos responsáveis. Quando existe termo, inclui seu texto. Há link **Acessar Solicitação**.

O valor de devolução pode aparecer negativo no e-mail, porque a autorização é gravada com sinal negativo. Na tela, algumas apresentações usam valor absoluto. Isso não indica automaticamente inconsistência de valor.

## Mensagens de lote

O aviso de geração para inscritos apresenta quantidade de despesas, valor total, não reembolsável, desconto e reembolso. O texto dirigido ao próprio dono do lote pede que aguarde a validação financeira.

O aviso de aprovação dirigido ao colaborador é mais curto: informa aprovação e previsão, quando há valor reembolsável. Não inclui o novo resumo e a mensagem de acerto de saldo previstos na proposta de nova rotina de adiantamentos.

Um lote fechado sem pagamento pode produzir assunto de conclusão conforme o valor reembolsável, e não necessariamente conforme o valor efetivamente transferido. A comprovação do valor pago é feita pelos dados da baixa e pelo procedimento externo da empresa.

## Lembrete diário

A tarefa das **00h30**, no fuso da aplicação, envia lembrete quando há lotes ainda não iniciados na revisão ou lotes ativos aprovados aguardando pagamento. Lotes em revisão ou já rejeitados não entram na mesma contagem de revisão inicial.

**Limitação da revisão:** o trecho que monta a lista de pendências de pagamento do e-mail percorre a coleção de revisão, embora a contagem de pagamentos seja obtida separadamente. Por isso, o conteúdo enumerado do lembrete pode divergir da fila real. Use a tela de Pagamentos de Lotes como referência para a baixa e encaminhe a divergência ao suporte. A documentação registra o comportamento; não modifica a rotina.

## Consultar o histórico de e-mails

Em **Logs → E-mails**, abra um registro para ver destinatário, assunto, data/hora, status e conteúdo. O log é criado no evento de notificação enviada e usa o status padrão `sent`.

A tela não oferece reenvio. Não foi identificado registro abrangente de todas as falhas por esse listener, nem rastreamento de leitura ou confirmação de entrega na caixa postal. O fato de a coluna indicar Enviado não significa que o destinatário leu a mensagem.

Para investigar um aviso não recebido, confira o e-mail da pessoa, o vínculo como responsável ou inscrito, a existência do evento gerador, o histórico e a configuração de envio com o suporte.

## Referências da revisão

[Notificações de autorização](../../../app/Notifications/AuthorizationNotification.php), [notificações de lote](../../../app/Notifications/BatchNotification.php), [lembrete](../../../app/Notifications/PendingBatchesNotification.php), [tarefa do lembrete](../../../app/Console/Commands/EmailPendingBatches.php), [destinatários](../../../app/Http/Controllers/User/UserNotificationController.php), [listener de log](../../../app/Listeners/LogSentNotification.php), [eventos](../../../app/Providers/EventServiceProvider.php), [log de e-mails](../../../app/Http/Controllers/Log/NotificationLogController.php).
