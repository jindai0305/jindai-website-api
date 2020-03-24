<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Passport;


use Laravel\Passport\TokenRepository;

/**
 * Class TokenCacheRepository
 * @package App\Passport
 */
class TokenCacheRepository extends TokenRepository
{
    protected $cache = [];

    /**
     * @inheritdoc
     */
    public function find($id)
    {
        if (!isset($this->cache[$id])) {
            $this->cache[$id] = parent::find($id);
        }

        return $this->cache[$id];
    }


    /**
     * @inheritdoc
     */
    public function isAccessTokenRevoked($id)
    {
        if ($token = $this->find($id)) {
            return $token->revoked;
        }
        return true;
    }
}
