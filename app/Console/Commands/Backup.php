<?php

namespace App\Console\Commands;

use App\Models\TaskLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Backup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Efetua backup do sistema e banco de dados';

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

        $output = "";

        Artisan::call('backup:clean');
        $output .= Artisan::output();

        $output .= PHP_EOL . PHP_EOL;

        try {

            Artisan::call('backup:run', [
                '--only-db' => true
            ]);

            $output .= Artisan::output();
        } catch (\Throwable $e) {

            $output .= $e->getMessage();
            $output .= PHP_EOL;
            $output .= $e->getTraceAsString();
        }


        //php artisan backup:run --only-db
        //php artisan backup:run --only-files

        $log->end_time = now();
        $log->details = $output;
        $log->save();

        $this->warn($output);
        $this->info('Tarefa ' . $this->signature . ' executada com sucesso!');
    }
}
