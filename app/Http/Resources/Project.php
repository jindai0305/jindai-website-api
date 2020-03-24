<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 Jindai.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Resources;

use App\Traits\ResourceTrait;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Project
 * @package App\Http\Resources
 *
 * @mixin \App\Models\Project
 */
class Project extends JsonResource
{
    use ResourceTrait;

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="projectDefault",
     *     type="object",
     *     @SWG\Property(property="id", type="integer", description="id", example=1),
     *     @SWG\Property(property="title", type="string", description="标题", example="电商网站"),
     *     @SWG\Property(property="summary", type="string", description="简介", example="电商网站"),
     *     @SWG\Property(property="image", type="string", description="cover-image", example="/path/to/img"),
     *     @SWG\Property(property="github", type="string", description="git地址", example="github.com"),
     *     @SWG\Property(property="website", type="string", description="线上地址", example="http://www.baidu.com"),
     *     @SWG\Property(property="code", type="string", description="二维码", example="/path/to/img"),
     *     @SWG\Property(property="keywords", type="string", description="关键词", example="PHP"),
     *     @SWG\Property(property="start_time", type="integer", description="开始时间", example=1579501412),
     *     @SWG\Property(property="end_time", type="integer", description="结束时间", example=1579501412),
     *     @SWG\Property(property="type", type="integer", description="类型", example=1),
     *     @SWG\Property(property="status", type="integer", description="状态 显示与隐藏", example=1),
     *     @SWG\Property(property="created_at", type="integer", description="创建时间", example=1579501412),
     *     @SWG\Property(property="deleted_at", type="integer", description="删除时间", example=1579501412)
     * )
     */
    protected function toDefault($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'image' => $this->image,
            'github' => $this->github,
            'website' => $this->website,
            'code' => $this->code,
            'keywords' => $this->keywords,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'type' => $this->type,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="projectIndex",
     *     type="object",
     *     @SWG\Property(property="id", type="integer", description="id", example=1),
     *     @SWG\Property(property="title", type="string", description="标题", example="电商网站"),
     *     @SWG\Property(property="summary", type="string", description="简介", example="电商网站"),
     *     @SWG\Property(property="image", type="string", description="cover-image", example="/path/to/img"),
     *     @SWG\Property(property="github", type="string", description="git地址", example="github.com"),
     *     @SWG\Property(property="website", type="string", description="线上地址", example="http://www.baidu.com"),
     *     @SWG\Property(property="code", type="string", description="二维码", example="/path/to/img"),
     *     @SWG\Property(property="keywords", type="string", description="关键词", example="PHP"),
     *     @SWG\Property(property="start_time", type="integer", description="开始时间", example=1579501412),
     *     @SWG\Property(property="end_time", type="integer", description="结束时间", example=1579501412),
     *     @SWG\Property(property="type", type="integer", description="类型", example=1)
     * )
     */
    protected function toIndex($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'image' => $this->image,
            'github' => $this->github,
            'website' => $this->website,
            'code' => $this->code,
            'keywords' => $this->keywords,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'type' => $this->type
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="projectView",
     *     type="object",
     *     @SWG\Property(property="id", type="integer", description="id", example=1),
     *     @SWG\Property(property="title", type="string", description="标题", example="电商网站"),
     *     @SWG\Property(property="summary", type="string", description="简介", example="电商网站"),
     *     @SWG\Property(property="image", type="string", description="cover-image", example="/path/to/img"),
     *     @SWG\Property(property="github", type="string", description="git地址", example="github.com"),
     *     @SWG\Property(property="website", type="string", description="线上地址", example="http://www.baidu.com"),
     *     @SWG\Property(property="code", type="string", description="二维码", example="/path/to/img"),
     *     @SWG\Property(property="keywords", type="string", description="关键词", example="PHP"),
     *     @SWG\Property(property="start_time", type="integer", description="开始时间", example=1579501412),
     *     @SWG\Property(property="end_time", type="integer", description="结束时间", example=1579501412),
     *     @SWG\Property(property="type", type="integer", description="类型", example=1),
     *     @SWG\Property(property="status", type="integer", description="状态", example=1),
     *     @SWG\Property(property="content", type="integer", description="内容", example="这是个内容")
     * )
     */
    protected function toView($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'image' => $this->image,
            'github' => $this->github,
            'website' => $this->website,
            'code' => $this->code,
            'keywords' => $this->keywords,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'type' => $this->type,
            'status' => $this->status,
            'content' => $this->content
        ];
    }
}
