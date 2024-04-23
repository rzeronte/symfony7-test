<?php

namespace App\Shared\Infrastructure\Rest;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class ApiQueryPage
{
    protected MessageBusInterface $queryBus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @throws \Throwable
     */
    protected function ask(object $message): mixed
    {
        try {
            $envelop = $this->queryBus->dispatch($message);

            $handledStamp = $envelop->last(HandledStamp::class);
            assert($handledStamp instanceof HandledStamp);

            return $handledStamp->getResult();
        } catch (HandlerFailedException $e) {
            throw $this->raiseException($e);
        }
    }

    protected function raiseException(\Throwable $e): \Throwable
    {
        while ($e instanceof HandlerFailedException) {
            $e = $e->getPrevious();
            assert($e instanceof \Throwable);
        }

        return $e;
    }
}
