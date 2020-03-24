<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class createDefaultSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:create:default-setting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create default setting';

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
     * @param Setting $model
     */
    public function handle(Setting $model)
    {
        if (!$model->find(config('website.setting.id'))) {
            $setting = $model->create([
                'title' => '标题',
                'description' => '说明',
                'keywords' => ['关键词'],
                'logo' => [],
                'alipay' => [],
                'wechat' => [],
                'avatar' => [],
                'nick_name' => '昵称',
            ]);
            DB::table(Setting::tableName())->where('id', $setting->id)->update(['id' => config('website.setting.id')]);
        }
        $this->info('---默认设置创建成功---');
    }
}
