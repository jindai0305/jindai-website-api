<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class TrackSql
 * @package App\Listeners
 */
class TrackSql
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param QueryExecuted $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
//        if (env('APP_ENV', 'production') == 'local') {
//            $sql = str_replace("?", "'%s'", $event->sql);
//            $log = vsprintf($sql, $event->bindings);
//            \Log::info($log);
//        }
        if (config('app.debug') === false) {
            return;
        }
        $sql = str_replace("?", "'%s'", $event->sql);
        var_export_data($sql);
        var_export_data($event->bindings);
        var_export_data('----------------------------------------------');
    }
}
