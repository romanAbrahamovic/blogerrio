<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class InsufficientPermissionsException
 * @package App\Exception
 */
class InsufficientPermissionsException extends GeneralErrorException
{
    protected int $statusCode = Response::HTTP_FORBIDDEN;
    protected string $statusMessage = 'You do not have a permissions to access this resource';
}