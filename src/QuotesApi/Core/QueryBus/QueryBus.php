<?php

declare(strict_types=1);

namespace QuotesApi\Core\QueryBus;

interface QueryBus
{
    public function query(Query $query): Result;
}
