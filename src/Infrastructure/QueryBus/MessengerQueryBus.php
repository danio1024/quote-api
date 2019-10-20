<?php

declare(strict_types=1);

namespace Infrastructure\QueryBus;

use QuotesApi\Core\QueryBus\Query;
use QuotesApi\Core\QueryBus\QueryBus;
use QuotesApi\Core\QueryBus\Result;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerQueryBus implements QueryBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function query(Query $query): Result
    {
        return $this->handle($query);
    }
}
