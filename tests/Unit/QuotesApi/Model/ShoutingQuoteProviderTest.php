<?php

declare(strict_types=1);

namespace App\Tests\Unit\QuotesApi\Model;

use QuotesApi\Model\Quote;
use QuotesApi\Model\QuoteProvider;
use QuotesApi\Model\ShoutingQuoteProvider;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

final class ShoutingQuoteProviderTest extends TestCase
{
    const AUTHOR_SLUG = 'steve-jobs';
    const AUTHOR_NAME = 'Steve Jobs';

    /**
     * @dataProvider dataProvider
     */
    public function testShouting(string $innerProviderQuote, string $expectedShout): void
    {
        $provider = $this->getInstanceWithMockedInnerProvider($innerProviderQuote);

        $quotes = $provider->forAuthorWithLimit(self::AUTHOR_SLUG, 1);
        $quote = reset($quotes);

        $this->assertEquals($expectedShout, $quote->quote());
    }

    public function dataProvider(): \Generator
    {
        yield ['Test Shouting', 'TEST SHOUTING!'];
        yield ['Test Shouting with dot.', 'TEST SHOUTING WITH DOT!'];
        yield ['Test Shouting!', 'TEST SHOUTING!'];
        yield ['', '!']; // silent shout? not in spec so leaving the exclamation mark
    }

    private function getInstanceWithMockedInnerProvider(string $quote): ShoutingQuoteProvider
    {
        $mock = \Mockery::mock(QuoteProvider::class);

        $mock
            ->allows()
            ->forAuthorWithLimit(self::AUTHOR_SLUG, 1)
            ->andReturn([new Quote(self::AUTHOR_NAME, $quote)])
        ;

        return new ShoutingQuoteProvider($mock);
    }
}
