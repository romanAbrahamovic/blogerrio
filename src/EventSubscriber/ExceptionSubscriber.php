<?php

namespace App\EventSubscriber;

use App\Exception\ErrorExceptionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;


class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @param ExceptionEvent $event
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ErrorExceptionInterface) {
            $errorExceptionData = [];
            $errorExceptionData['message'] = $exception->getMessage();
            $errorExceptionData['code'] = $exception->getCode();
            $errorExceptionData['statusCode'] = $exception->getStatusCode();

            $event->setResponse(new JsonResponse($errorExceptionData, $exception->getStatusCode()));
        }
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
