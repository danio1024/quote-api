<?php

declare(strict_types=1);

namespace QuotesApi\Query\Query;

use QuotesApi\Core\QueryBus\Query;

final class QuotesByAuthorQuery implements Query
{
    private $authorSlug;
    private $limit;

    public function __construct(string $authorSlug, int $limit = 1)
    {
        $this->authorSlug = $authorSlug;
        $this->limit = $limit;
    }

    public function authorSlug(): string
    {
        return $this->authorSlug;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}
