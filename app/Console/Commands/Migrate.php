<?php

namespace App\Console\Commands;

use App\Models\TaskLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Migrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica as migrações e executa o que estiver pendente';

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

        Artisan::call('migrate');
        $output = Artisan::output();

        $log->end_time = now();
        $log->details = $output;
        $log->save();

        $this->warn($output);
        $this->info('Tarefa ' . $this->signature . ' executada com sucesso!');
    }
}
