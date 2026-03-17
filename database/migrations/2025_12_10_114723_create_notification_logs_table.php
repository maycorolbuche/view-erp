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
            $table->string('notification_type');
            $table->string('notifiable_type');
            $table->unsignedInteger('id_user');
            $table->string('channel');           // Ex: mail, database, etc.
            $table->string('recipient')->nullable();
            $table->string('subject')->nullable();
            $table->longText('message')->nullable();    // Dados da notificação
            $table->text('data')->nullable(); //$table->json('data')->nullable();    // Dados da notificação
            $table->string('type')->nullable();    // Dados da notificação
            $table->text('response')->nullable(); //$table->json('response')->nullable(); // Resposta do serviço (se houver)
            $table->string('status')->default('sent'); // sent, failed, queued, delivered
            $table->text('error_message')->nullable(); // Mensagem de erro se falhar
            $table->timestamp('sent_at');

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->index(['notification_type', 'sent_at']);
            $table->index(['notifiable_type', 'id_user']);
            $table->index(['channel', 'status']);
            $table->index('sent_at');

            $table->foreign('created_by')->references('id_user')->on('users');
            $table->foreign('updated_by')->references('id_user')->on('users');
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
