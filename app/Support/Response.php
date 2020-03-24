<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Support;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * Class Response
 * @package App\Support
 *
 * @property-read ResponseFactory $response
 */
class Response
{
    protected $response;

    protected $status_code = HttpResponse::HTTP_OK;

    protected $error_code = 0;

    protected $error_msg = null;

    protected $meta = null;

    protected $header = [];

    protected $data = null;

    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * 获取http状态
     * @return int
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * 获取结果
     * @return int
     */
    public function getContent()
    {
        return $this->data;
    }

    /**
     * @param array $header
     * @return $this
     */
    public function setHeader(array $header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param int $status_code
     * @return $this
     */
    public function setStatusCode(int $status_code)
    {
        $this->status_code = $status_code;
        return $this;
    }

    /**
     * @param int $error_code
     * @return $this
     */
    public function setErrorCode(int $error_code)
    {
        $this->error_code = $error_code;
        return $this;
    }

    /**
     * @param string $error_message
     * @return $this
     */
    public function setErrorMessage(string $error_message)
    {
        $this->error_msg = $error_message;
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setContent($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param $meta
     * @return $this
     */
    public function setMeta($meta)
    {
        if (!($meta && count((array)$meta))) {
            return $this;
        }

        if (is_null($this->meta)) {
            $this->meta = $meta;
        } else {
            $this->meta = array_merge($this->meta, $meta);
        }
        return $this;
    }

    /**
     * 200
     *
     * @param null $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($resource = null)
    {
        return $this->setContent($resource)->json();
    }

    /**
     * 201
     *
     * @param null $resource
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function created($resource = null, $code = 201, $message = 'success')
    {
        return $this->setStatusCode(HttpResponse::HTTP_CREATED)
            ->setErrorCode($code)
            ->setErrorMessage($message)
            ->setContent($resource)
            ->json();
    }

    /**
     * 204
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function noContent()
    {
        return $this->setStatusCode(HttpResponse::HTTP_NO_CONTENT)
            ->json();
    }

    /**
     * 401
     *
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function unauthorized($code = 401, $message = 'message')
    {
        return $this->setStatusCode(HttpResponse::HTTP_UNAUTHORIZED)
            ->setErrorCode($code)
            ->setErrorMessage($message)
            ->json();
    }

    /**
     * 404
     *
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFound($code = 404, $message = "Not Found")
    {
        return $this->setStatusCode(HttpResponse::HTTP_NOT_FOUND)
            ->setErrorCode($code)
            ->setErrorMessage($message)
            ->json();
    }

    /**
     * 429
     *
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function tooManyRequests($code = 429, $message = 'Too Many Requests')
    {
        return $this->setStatusCode(HttpResponse::HTTP_TOO_MANY_REQUESTS)
            ->setErrorCode($code)
            ->setErrorMessage($message)
            ->json();
    }

    /**
     *
     * @param int $status_code
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function internalServer($status_code, $code = 500, $message = 'Internal Server Error')
    {
        return $this->setStatusCode($status_code)
            ->setErrorCode($code)
            ->setErrorMessage($message)
            ->json();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    private function json()
    {
        return $this->response->json($this->buildJsonData(), $this->status_code, $this->header);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function send()
    {
        return $this->json();
    }

    /**
     * @return array
     */
    private function buildJsonData()
    {
        $response = array_merge([
            'error_code' => $this->error_code,
            'error_msg' => $this->getMessage()
        ], $this->getSendContent());

        if (!is_null($this->meta)) {
            return array_merge($response, [
                'meta' => $this->meta
            ]);
        }
        return $response;
    }

    /**
     * @return string|null
     */
    private function getMessage()
    {
        if (is_null($this->error_msg)) {
            return 'success';
        }
        return $this->error_msg;
    }

    /**
     * @return array
     */
    private function getSendContent()
    {
        return ['data' => $this->data];
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return json_encode($this->buildJsonData());
    }
}
