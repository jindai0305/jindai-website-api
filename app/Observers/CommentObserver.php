<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Observers;


use App\Jobs\FilterThreadSensitiveWords;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

/**
 * Class CommentObserver
 * @package App\Observers
 */
class CommentObserver
{
    /**
     * @param Comment $model
     */
    public function created(Comment $model)
    {
        $model->item->increment('comment_nums', 1);
    }

    /**
     * @param Comment $model
     */
    public function saving(Comment $model)
    {
        if (!$model->user_id) {
            $model->user_id = Auth::guard('api')->id();
        }
        if (!$model->reply_id) {
            $model->reply_id = -1;
        }

        $model->content = \dispatch_now(new FilterThreadSensitiveWords($model->content));
    }

    /**
     * @param Comment $model
     */
    public function saved(Comment $model)
    {

    }

    /**
     * @param Comment $model
     */
    public function online(Comment $model)
    {
        $model->item->increment('comment_nums', 1);
    }

    /**
     * @param Comment $model
     */
    public function offline(Comment $model)
    {
        $model->item->increment('comment_nums', -1);
    }

    /**
     * @param Comment $model
     */
    public function deleted(Comment $model)
    {
        $model->item->increment('comment_nums', -1);
    }

    /**
     * @param Comment $model
     */
    public function restored(Comment $model)
    {
        $model->item->increment('comment_nums', 1);
    }
}
