<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\Controller;
use App\Http\Resources\AttachmentsCollection;
use App\Models\Attachments;
use App\Repositories\AttachmentsRepository;
use Illuminate\Http\Request;

/**
 * Class DefaultController
 * @package App\Http\Controllers\Api
 *
 * @SWG\Tag(name="Admin - Attachments", description="其他")
 */
class AttachmentsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function __construct(AttachmentsRepository $attachments)
    {
        parent::__construct();
        $this->model = $attachments;
    }

    /**
     * 获取上传的资源
     *
     * @param Request $request
     * @return Attachments[]|\Illuminate\Database\Eloquent\Collection
     *
     * @SWG\Get(path="/admin/attachments",
     *     tags={"Admin - Attachments"},
     *     description="获取上传的资源",
     *     produces={"application/json"},
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/attachmentsDefault"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function list(Request $request)
    {
        return $this->resourceInstance(AttachmentsCollection::class, $this->model->paginate($request))
            ->addMeta($this->model->getMeta($request));
    }
}
