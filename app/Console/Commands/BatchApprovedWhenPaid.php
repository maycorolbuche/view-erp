<?php

namespace App\Console\Commands;

use App\Models\TaskLog;
use App\Models\Batch;
use Illuminate\Console\Command;

class BatchApprovedWhenPaid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:batch_approved_when_paid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marca os lotes pagos como aprovados';

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

        $return = Batch::where('active', 0)
            ->update([
                'revised_status' => 'approved'
            ]);

        $log->end_time = now();
        $log->details = $return;
        $log->save();

        $this->warn($return);
        $this->info('Tarefa ' . $this->signature . ' executada com sucesso!');
    }
}
