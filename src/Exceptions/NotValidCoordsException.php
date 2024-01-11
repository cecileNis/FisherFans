<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

    class NotValidCoordsException extends HttpException
    {
        public function __construct(\Throwable $previous = null, int $code = 0, array $headers = [])
        {
            parent::__construct(403, "Input coords are not validable.", $previous, $headers, $code);
        }
    }