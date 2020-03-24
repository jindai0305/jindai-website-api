<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Exceptions;


use Illuminate\Http\JsonResponse;

/**
 * Trait PrepareResponse
 * @package App\Exceptions
 */
trait PrepareResponse
{
    protected $_response;

    /**
     * @param $data
     * @param $message
     * @param $statusCode
     */
    protected function prepareResponse($data, $message, $statusCode)
    {
        $this->_response = [
            "error_code" => $statusCode,
            "error_msg" => $message,
            'data' => $data,
        ];
    }

    /**
     * @return mixed
     */
    protected function getResponse()
    {
        return $this->_response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function render($request): JsonResponse
    {
        return new JsonResponse($this->getResponse(), $this->getStatusCode());
    }
}
