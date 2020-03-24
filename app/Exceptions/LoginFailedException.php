<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class LoginFailedException
 * @package App\Exceptions
 */
class LoginFailedException extends HttpException implements CustomizeException
{
    use PrepareResponse;

    /**
     * LoginFailedException constructor.
     * @param $data
     * @param string $message
     * @param int $statusCode
     * @param \Throwable|null $previous
     * @param array $headers
     * @param int|null $code
     */
    public function __construct($data, string $message = 'Unauthorized', int $statusCode = 401, \Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        $this->prepareResponse($data, $message, $statusCode);
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
