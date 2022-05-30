<?php

namespace App\Exception;

interface ErrorExceptionInterface
{
    public function getStatusCode(): int;
}