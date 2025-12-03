<?php

namespace App\Console\Commands;

use App\Models\TaskLog;
use App\Models\File;
use App\Models\Expense;
use App\Helpers\FileUploadHelper;
use Illuminate\Console\Command;

class DeleteExcessFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:delete_excess_files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apaga os arquivos em excesso';

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

        $files = File::where('type', 'expenses')
            ->whereNotIn('id_file', Expense::whereNotNull('id_file')->pluck('id_file'))
            ->get();

        $deleted = [];
        foreach ($files as $file) {
            $deleted[] = FileUploadHelper::delete($file->id_file);
        }

        $return =  json_encode($deleted);

        $log->end_time = now();
        $log->details = $return;
        $log->save();

        $this->warn($return);
        $this->info('Tarefa ' . $this->signature . ' executada com sucesso!');
    }
}
