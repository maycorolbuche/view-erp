<?php

namespace App\Console\Commands;

use App\Models\TaskLog;
use Illuminate\Console\Command;
use App\Models\Notification as NotificationModel;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PendingBatchesNotification;
use App\Models\Batch;

class EmailPendingBatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:email_pending_batches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia e-mail para informar que existem lotes pendentes de revisão/pagamento';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->warn('Tarefa: ' . $this->signature);
        $this->warn($this->description);

        $log = new TaskLog();
        $log->signature = $this->signature;
        $log->description = $this->description;
        $log->start_time = now();
        $log->save();

        $batches_review_pending = Batch::select()->reviewPending()->whereNull('revised_by')->count();
        $batches_payment_pending = Batch::select()->paymentPending()->count();

        if ($batches_review_pending + $batches_payment_pending > 0) {
            $notifications = NotificationModel::where('slug', 'batch_review')->with(['users_notifications.user'])->first();
            foreach ($notifications->users_notifications as $notification) {
                Notification::send($notification->user, new PendingBatchesNotification());
            }

            $return = 'E-mail disparado';
        } else {
            $return = 'Não há dados para serem disparados!';
        }

        $log->end_time = now();
        $log->details = $return;
        $log->save();

        $this->warn($return);
        $this->info('Tarefa ' . $this->signature . ' executada com sucesso!');
    }
}
