<?php

declare(strict_types=1);

namespace QuotesApi\Query\Result;

use QuotesApi\Core\QueryBus\Result;
use QuotesApi\Model\Quote;

final class QuotesByAuthorResult implements Result
{
    private $quotes;

    public function __construct(Quote... $quotes)
    {
        $this->quotes = $quotes;
    }

    /**
     * @return Quote[]
     */
    public function quotes(): array
    {
        return $this->quotes;
    }

    public function count(): int
    {
        return \count($this->quotes);
    }

    public function toArray(): array
    {
        return array_map(function (Quote $quote) {
            return $quote->quote();
        }, $this->quotes);
    }
}
