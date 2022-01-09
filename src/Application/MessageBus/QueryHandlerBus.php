<?php

namespace ExchangeReport\Application\MessageBus;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class QueryHandlerBus
 * @package ExchangeReport\Application\MessageBus
 */
class QueryHandlerBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @param object|Envelope $query
     *
     * @return mixed The handler returned value
     */
    public function query($query): mixed
    {
        return $this->handle($query);
    }
}
