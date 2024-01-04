<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

    class UserNeedALicenceException extends HttpException
    {
        public function __construct(\Throwable $previous = null, int $code = 0, array $headers = [])
        {
            parent::__construct(403, "You need a licence to add a boat.", $previous, $headers, $code);
        }
    }