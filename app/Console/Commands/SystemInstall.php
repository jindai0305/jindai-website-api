<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SystemInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install the system';

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
     * @return mixed
     */
    public function handle()
    {
        $this->execShellWithPrettyPrint('php artisan key:generate');
        $this->execShellWithPrettyPrint('php artisan migrate');
        $this->execShellWithPrettyPrint('php artisan db:seed');
        $this->execShellWithPrettyPrint('chown www-data:www-data -R "storage"');
        $this->execShellWithPrettyPrint('php artisan passport:install');
        $this->execShellWithPrettyPrint('php artisan storage:link');
        $this->execShellWithPrettyPrint('php artisan system:create:default-setting');
    }

    public function execShellWithPrettyPrint($command)
    {
        $this->info('---');
        $this->info($command);
        $output = shell_exec($command);
        $this->info($output);
        $this->info('---');
    }
}
