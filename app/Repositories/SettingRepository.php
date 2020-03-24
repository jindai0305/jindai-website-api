<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;


use App\Models\Setting;

/**
 * Class SettingRepository
 * @package App\Repositories
 */
class SettingRepository extends BaseRepository
{
    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules($model)
    {
        return [
            'title' => 'max:50',
            'description' => 'max:120',
            'nick_name' => 'max:8',
            'signature' => 'max:12',
            'repair' => 'boolean',
            'message' => 'boolean',
            'comment' => 'boolean',
            'reward' => 'boolean',
            'contact' => 'boolean',
            'visibility' => 'boolean',
        ];
    }
}
