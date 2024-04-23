<?php

namespace App\Shared\Infrastructure\Listener;

use Assert\Assert;
use Assert\AssertionFailedException;
use Assert\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class ExceptionListener
{
    /** @var array<string, int> */
    private array $exceptions = [
        Assert::class => Response::HTTP_BAD_REQUEST,
        AssertionFailedException::class => Response::HTTP_BAD_REQUEST,
        InvalidArgumentException::class => Response::HTTP_BAD_REQUEST,
    ];

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = $this->createApiResponse($exception, $this->httpStatusCodeFor($exception));
        $event->setResponse($response);
    }

    /**
     * Creates the ApiResponse from any Exception.
     */
    private function createApiResponse(\Throwable $exception, int $statusCode): JsonResponse
    {
        $detail = $exception->getMessage();

        return new JsonResponse(
            [
                'error' => [
                    'status' => $statusCode,
                    'detail' => $detail,
                ], ],
            $statusCode
        );
    }

    private function httpStatusCodeFor(\Throwable $exception): int
    {
        if ($exception instanceof HandlerFailedException) {
            $exception = $exception->getPrevious();
        }

        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        foreach ($this->exceptions as $key => $value) {
            if (!($exception instanceof $key)) {
                continue;
            }

            return $value;
        }

        return 501;
    }
}
