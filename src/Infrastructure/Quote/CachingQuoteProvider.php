<?php

declare(strict_types=1);

namespace Infrastructure\Quote;

use Infrastructure\Cache\Cache;
use QuotesApi\Model\Quote;
use QuotesApi\Model\QuoteProvider;

final class CachingQuoteProvider implements QuoteProvider
{
    private const TTL_SECONDS = 120;

    private $innerProvider;
    private $cache;

    public function __construct(QuoteProvider $innerProvider, Cache $cache)
    {
        $this->innerProvider = $innerProvider;
        $this->cache = $cache;
    }

    /** @return Quote[] */
    public function forAuthorWithLimit(string $authorSlug, int $limit): array
    {
        $cacheKey = $this->createKey($authorSlug, $limit);

        if ($cacheValue = $this->cache->get($cacheKey)) {
            return $this->deserialize($cacheValue);
        }

        $quotes = $this->innerProvider->forAuthorWithLimit($authorSlug, $limit);

        if ($quotes) {
            $this->cache->set(
                $cacheKey,
                $this->serialize($quotes),
                self::TTL_SECONDS
            );
        }

        return $quotes;
    }

    private function createKey(string $authorSlug, int $limit): string
    {
        return sprintf('quotes:%s-%d', $authorSlug, $limit);
    }

    private function deserialize(string $json): array
    {
        $quotesArray = json_decode($json, true);

        return array_map(function (array $quote) {
            return new Quote($quote['author'], $quote['quote']);
        }, $quotesArray);
    }

    private function serialize(array $quotes): string
    {
        $quotesArray = array_map(function (Quote $quote) {
            return [
                'author' => $quote->author(),
                'quote' => $quote->quote(),
            ];
        }, $quotes);

        return json_encode($quotesArray);
    }
}
