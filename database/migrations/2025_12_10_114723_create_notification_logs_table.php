<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id('id_notification_log');
            $table->string('notification_type'); // Ex: App\Notifications\AuthorizationNotification
            $table->string('notifiable_type');   // Ex: App\Models\User
            $table->unsignedBigInteger('notifiable_id'); // ID do destinatário
            $table->string('channel');           // Ex: mail, database, etc.
            $table->string('recipient')->nullable(); // Email ou outro identificador
            $table->string('subject')->nullable(); // Assunto do email
            $table->json('data')->nullable();    // Dados da notificação
            $table->json('response')->nullable(); // Resposta do serviço (se houver)
            $table->string('status')->default('sent'); // sent, failed, queued, delivered
            $table->text('error_message')->nullable(); // Mensagem de erro se falhar
            $table->timestamp('sent_at');
            $table->timestamps();

            $table->index(['notification_type', 'sent_at']);
            $table->index(['notifiable_type', 'notifiable_id']);
            $table->index(['channel', 'status']);
            $table->index('sent_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_logs');
    }
}
