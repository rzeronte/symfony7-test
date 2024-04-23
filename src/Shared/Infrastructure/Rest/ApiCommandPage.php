<?php

namespace App\Shared\Infrastructure\Rest;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class ApiCommandPage
{
    protected MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @throws \Throwable
     */
    protected function dispatch(object $message): Envelope
    {
        try {
            return $this->commandBus->dispatch($message);
        } catch (HandlerFailedException $e) {
            while ($e instanceof HandlerFailedException) {
                $e = $e->getPrevious();
                assert($e instanceof \Throwable);
            }

            throw $e;
        }
    }
}
