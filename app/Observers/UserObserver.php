<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Observers;

use App\Models\User;

/**
 * Class UserObserver
 * @package App\Observers
 */
class UserObserver
{
    /**
     * Handle the example "created" event.
     *
     * @param  User $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the example "updated" event.
     *
     * @param  User $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * @param User $user
     */
    public function saving(User $user)
    {
        if (request()->user('api') && request()->user('api')->is_super) {
            if (request()->get('is_admin', false)) {
                $user->addFlag(User::FLAG_ADMIN);
            } else {
                $user->removeFlag(User::FLAG_ADMIN);
            }
        }

        // 如果是新增用户且没有密码 给默认密码
        if ($user->isModelCreate() && !$user->password) {
            $user->password = $user->name . '123456';
        }
    }

    /**
     * Handle the example "saved" event.
     *
     * @param  User $user
     * @return void
     */
    public function saved(User $user)
    {
        //
    }

    /**
     * Handle the example "deleted" event.
     *
     * @param  User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the example "restored" event.
     *
     * @param  User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the example "force deleted" event.
     *
     * @param  User $example
     * @return void
     */
    public function forceDeleted(User $example)
    {
        //
    }
}
