<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class Exception
 * @package App\Exceptions
 */
class Exception extends HttpException implements CustomizeException
{
    use PrepareResponse;

    /**
     * Exception constructor.
     * @param $data
     * @param string|null $message
     * @param int $statusCode
     * @param \Exception|null $previous
     * @param array $headers
     * @param int|null $code
     */
    public function __construct($data, string $message = null, int $statusCode = 400, \Exception $previous = null, array $headers = array(), ?int $code = 0)
    {
        $this->prepareResponse($data, $message, $statusCode);
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
