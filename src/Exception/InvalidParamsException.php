<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class InvalidParamsException
 * @package App\Exception
 */
class InvalidParamsException extends GeneralErrorException
{
    protected int $statusCode = Response::HTTP_BAD_REQUEST;
    protected string $statusMessage = 'Invalid params provided';
}