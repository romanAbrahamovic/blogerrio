<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Class GeneralErrorException
 * @package App\Exception
 */
class GeneralErrorException extends \DomainException implements ErrorExceptionInterface
{
    protected int $statusCode = Response::HTTP_BAD_REQUEST;
    protected string $statusMessage = 'Error happen, please try again later';

    /**
     * GeneralErrorException constructor.
     * @param string $message
     * @param int $code
     * @param int|null $statusCode
     */
    final public function __construct(string $message = "", int $code = 0, int $statusCode = null)
    {
        if (empty($message)) {
            $message = $this->statusMessage;
        }

        parent::__construct($message, $code);
        if ($statusCode) {
            $this->statusCode = $statusCode;
        }
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}