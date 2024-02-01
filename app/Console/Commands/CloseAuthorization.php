<?php

namespace App\Console\Commands;

use App\Models\TaskLog;
use App\Helpers\AuthorizationHelper;
use Illuminate\Console\Command;

class CloseAuthorization extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:close_authorizations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encerra autorizações expiradas';

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

        $return = AuthorizationHelper::close_expired();

        $log->end_time = now();
        $log->details = $return;
        $log->save();

        $this->warn($return);
        $this->info('Tarefa ' . $this->signature . ' executada com sucesso!');
    }
}
