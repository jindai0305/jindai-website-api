<?php

namespace App\Console\Commands;

use App\Passport\ClientCacheRepository;
use Illuminate\Console\Command;
use Laravel\Passport\ClientRepository;

/**
 * Class FlushPassportCache
 * @package App\Console\Commands
 *
 * @property-read ClientCacheRepository $repository
 */
class FlushPassportCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:passport:cache-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'flush all passport cache';

    public $repository;

    /**
     * FlushPassportCache constructor.
     * @param ClientRepository $repository
     */
    public function __construct(ClientRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('---缓存清除开始---');
        $this->repository->forgetCache();
        $this->info('---缓存清除结束---');
    }
}
