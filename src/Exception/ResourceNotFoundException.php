<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class ResourceNotFoundException extends GeneralErrorException
{
    protected int $statusCode = Response::HTTP_NOT_FOUND;
    protected string $statusMessage = 'This resource not found';

}