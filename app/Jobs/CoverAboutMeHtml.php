<?php

namespace App\Jobs;

use App\Models\Item;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CoverAboutMeHtml implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $item;

    /**
     * @param Item $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @param SettingRepository $repository
     */
    public function handle(SettingRepository $repository)
    {
        /** @var Setting $model */
        $model = $repository->findModel(config('website.setting.id'));
        $model->content = $this->item->content;
        $model->save();
    }
}
