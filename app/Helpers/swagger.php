<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

/**
 * swagger 基本参数
 *
 * @SWG\Parameter(parameter="offsetPageParam", in="query", name="page", type="string", description="分页的页码"),
 * @SWG\Parameter(parameter="offsetLimitParam", in="query", name="limit", type="string", description="每次最大请求的数量"),
 *
 *
 * @SWG\Definition(
 *     definition="modelIdParam",
 *     type="object",
 *     @SWG\Property(property="id", type="integer", description="id", example=1),
 * )
 *
 * @SWG\Definition(
 *     definition="timeCreateParam",
 *     type="object",
 *     @SWG\Property(property="created_at", type="integer", description="创建时间", example=1569568881),
 * )
 */
