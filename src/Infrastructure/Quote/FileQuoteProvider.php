<?php

declare(strict_types=1);

namespace Infrastructure\Quote;

use Cocur\Slugify\Slugify;
use QuotesApi\Model\Quote;
use QuotesApi\Model\QuoteProvider;

final class FileQuoteProvider implements QuoteProvider
{
    private $quotesFile;

    public function __construct(string $quotesFile)
    {
        $this->quotesFile = $quotesFile;
    }

    /** @return Quote[] */
    public function forAuthorWithLimit(string $authorSlug, int $limit): array
    {
        $quotesJson = file_get_contents($this->quotesFile);

        $decodedQuotes = json_decode($quotesJson, true);

        $quoteObjects = array_map(function (array $quoteArray) {
            return new Quote(
                $quoteArray['author'],
                $quoteArray['quote']
            );
        }, $decodedQuotes['quotes']);

        return $this->filterWithLimit($authorSlug, $limit, ...$quoteObjects);
    }

    public function filterWithLimit(string $authorSlug, int $limit, Quote... $quotes): array
    {
        $resultCount = 0;
        $slugify = new Slugify();

        return array_filter($quotes, function (Quote $quote) use (&$resultCount, $limit, $slugify, $authorSlug) {
            if ($resultCount >= $limit) {
                return false;
            }

            if ($slugify->slugify($quote->author()) === $authorSlug) {
                $resultCount++;

                return true;
            }

            return false;
        });
    }
}
