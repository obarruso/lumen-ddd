<?php

namespace App\Common\Presentation\Cli;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run PHPUnit tests'; // Command description

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Executing tests.');

        $phpUnitExec = base_path('vendor/bin/phpunit');

        if (!file_exists($phpUnitExec)) {
            $this->error('PHPUnit is not installed.');
            return 1; // Return an error code
        }

        $process = new Process([$phpUnitExec]);

        $process->setTimeout(null); // Remove the timeout limit
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('PHPUnit tests failed.');
            $this->line($process->getOutput());
            return 1; // Return an error code
        }

        $this->info('PHPUnit tests passed.');
        // $this->line($process->getOutput());
    }
}
