<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Passport;


use Illuminate\Support\Facades\Cache;
use Laravel\Passport\ClientRepository;

/**
 * Class ClientCacheRepository
 * @package App\Passport
 */
class ClientCacheRepository extends ClientRepository
{
    const CACHE_KEY = 'passport_clients_cache';

    /**
     * @inheritdoc
     */
    public function revoked($id)
    {
        return Cache::rememberForever(self::CACHE_KEY, function () use ($id) {
            return parent::revoked($id);
        });
    }

    /**
     * flush客户端缓存
     *
     * @return bool
     */
    public function forgetCache()
    {
        return Cache::forget(self::CACHE_KEY);
    }
}
