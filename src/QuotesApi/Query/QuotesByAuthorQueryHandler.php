<?php

declare(strict_types=1);

namespace QuotesApi\Query;

use QuotesApi\Model\QuoteProvider;
use QuotesApi\Query\Query\QuotesByAuthorQuery;
use QuotesApi\Query\Result\QuotesByAuthorResult;

final class QuotesByAuthorQueryHandler
{
    private $quoteProvider;

    public function __construct(QuoteProvider $quoteProvider)
    {
        $this->quoteProvider = $quoteProvider;
    }

    public function __invoke(QuotesByAuthorQuery $query): QuotesByAuthorResult
    {
        $quotes = $this->quoteProvider->forAuthorWithLimit(
            $query->authorSlug(),
            $query->limit()
        );

        return new QuotesByAuthorResult(...$quotes);
    }
}
