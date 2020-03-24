<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Policies;


use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy extends InitialPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function destroy(User $user, Comment $comment)
    {
        return $user->isAdmin() || $user->id === $comment->user_id;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return !$user->isMuted();
    }
}
