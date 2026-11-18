# Monitoramento e logs

[Voltar ao manual](../README.md) · [Inventário completo](../inventario.md)

Os caminhos abaixo são relativos ao sistema selecionado; veja a convenção de endereços no guia de acesso.

<a id="notification-logs"></a>

## E-mails

**Menu:** Logs. **Caminho relativo:** `/logs/notification`.

Consultar e-mails registrados pelo sistema.

**Como usar.** Localize e abra o registro para ver assunto, destinatário, data/hora, status e o conteúdo enviado.

**Regras e efeitos.** Não há comando de reenvio nesta tela. O listener registra notificações enviadas com sucesso; ausência de registro não demonstra que não houve tentativa. O status Enviado não comprova leitura nem entrega na caixa de entrada.

**Ações apresentadas:** Cancelar. A disponibilidade depende da permissão e da etapa do registro.

**Colunas das listagens:** Código, Destinatário, Assunto, Data/Hora, Status. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Gravação:** esta tela é de consulta; não há operação de cadastro, alteração ou exclusão no controlador.

**Referência de conferência:** [NotificationLogController.php](../../../app/Http/Controllers/Log/NotificationLogController.php), [index.blade.php](../../../resources/views/notification-logs/index.blade.php).

<a id="task-logs"></a>

## Tarefas Agendadas

**Menu:** Logs. **Caminho relativo:** `/logs/tasks`.

Acompanhar o agendador e as execuções de tarefas.

**Como usar.** Confira o último acionamento e a última execução de cada tarefa; abra Detalhes para ler a saída e consulte o histórico abaixo.

**Regras e efeitos.** Início e término do acionamento não substituem os detalhes de cada tarefa. Uma execução sem término ou com erro nos detalhes deve ser analisada pelo suporte. Não há botões de execução manual nesta tela.

**Colunas das listagens:** Código, Chave, Descrição, Detalhes, Início, Fim. Listas de seleção inicial e históricos podem mostrar conjuntos diferentes.

**Gravação:** esta tela é de consulta; não há operação de cadastro, alteração ou exclusão no controlador.

**Referência de conferência:** [TaskLogController.php](../../../app/Http/Controllers/Log/TaskLogController.php), [index.blade.php](../../../resources/views/task-logs/index.blade.php).
