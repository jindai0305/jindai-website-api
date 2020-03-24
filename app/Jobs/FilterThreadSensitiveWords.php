<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Jobs;


use App\Filters\SensitiveFilter;
use Illuminate\Support\Facades\Auth;

/**
 * Class FilterThreadSensitiveWords
 * @package App\Jobs
 */
class FilterThreadSensitiveWords
{
    protected $content;

    /**
     * FilterThreadSensitiveWords constructor.
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function handle()
    {
        $sensitiveFilter = \app(SensitiveFilter::class);

        $isLegal = $sensitiveFilter->isLegal($this->content);

        if ($isLegal) {
            $cacheKey = 'thread_sensitive_trigger_' . Auth::guard('api')->id();

            if (!\Cache::has($cacheKey)) {
                \Cache::forever($cacheKey, 0);
            }

            \Cache::increment($cacheKey);

            $this->content = $sensitiveFilter->replace($this->content, '***');
        }

        return $this->content;
    }
}
