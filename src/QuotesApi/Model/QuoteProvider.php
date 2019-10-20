<?php

declare(strict_types=1);

namespace QuotesApi\Model;

interface QuoteProvider
{
    /** @return Quote[] */
    public function forAuthorWithLimit(string $authorSlug, int $limit): array;
}
