<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class InstallController extends Controller
{
    public function run()
    {
        $output = '';



        /* **************************** GIT **************************** */
        $gitRepo = env('GIT_REPO');
        $gitToken = env('GIT_TOKEN');

        if ($gitRepo <> "" && $gitToken <> "") {
            $gitUrl = 'https://' . $gitToken . '@github.com/' . $gitRepo;

            // Configurar remote com token (apenas se necessário)
            exec('git remote set-url origin ' . escapeshellarg($gitUrl), $gitSetUrlOutput, $gitSetUrlStatus);
            $output .= "\nGit remote set-url: " . implode("\n", $gitSetUrlOutput);

            // Puxar alterações
            exec('git pull origin main 2>&1', $gitPullOutput, $gitPullStatus);
            $output .= "\nGit pull: " . implode("\n", $gitPullOutput);
        }


        /* **************************** ARTISAN **************************** */
        $commands = [
            'migrate --force',
            'db:seed --force',
            'cache:clear',
            'view:clear',
            'config:clear',
            'route:clear',
        ];


        foreach ($commands as $command) {
            $output .= "\n CMD => " . $command;
            Artisan::call($command);
            $output .= "\n" . Artisan::output();
        }


        return response(trim($output))->header('Content-Type', 'text/plain');
    }
}
