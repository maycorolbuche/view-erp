<?php

namespace App\Console\Commands;

use App\Models\TaskLog;
use App\Helpers\BatchHelper;
use Illuminate\Console\Command;

class CloseBatchesWithoutRefund extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:close_batches_without_refund';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encerra lotes não reembolsáveis';

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

        $return = BatchHelper::close_without_refund();

        $log->end_time = now();
        $log->details = $return;
        $log->save();

        $this->warn($return);
        $this->info('Tarefa ' . $this->signature . ' executada com sucesso!');
    }
}
