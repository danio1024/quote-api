<?php

declare(strict_types=1);

namespace QuotesApi\Model;

final class ShoutingQuoteProvider implements QuoteProvider
{
    private $innerProvider;

    public function __construct(QuoteProvider $innerProvider)
    {
        $this->innerProvider = $innerProvider;
    }

    /** @return Quote[] */
    public function forAuthorWithLimit(string $authorSlug, int $limit): array
    {
        $quotes = $this->innerProvider->forAuthorWithLimit($authorSlug, $limit);

        return array_map(function (Quote $quote) {
            return new Quote($quote->author(), $this->shoutify($quote->quote()));
        }, $quotes);
    }

    private function shoutify(string $quote): string
    {
        $quote = preg_replace('/[\.!]$/', '', $quote);

        return strtoupper($quote) . '!';
    }
}
