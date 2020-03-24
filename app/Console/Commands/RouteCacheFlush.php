<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RouteCacheFlush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:cache-clear
                            {--name= : The names of the route to clear}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear route middleware cache';

    public $routes;

    /**
     * Create a new command instance.
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
        if (!$name = $this->option('name')) {
            $this->info('please entry clear name');
            return;
        }

        try {
            $routeName = route($name, [], false);
        } catch (\Exception $e) {
            $this->info('没有匹配到名称为`' . $name . '`的路由');
            return;
        }
        Cache::forget(build_cache_key($routeName));

        $this->info('--路由名称为`' . $name . '`的缓存清除成功--');
    }
}
