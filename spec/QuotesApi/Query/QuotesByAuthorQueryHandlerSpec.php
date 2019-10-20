<?php

namespace spec\QuotesApi\Query;

use Prophecy\Argument;
use QuotesApi\Model\Quote;
use QuotesApi\Model\QuoteProvider;
use QuotesApi\Query\Query\QuotesByAuthorQuery;
use QuotesApi\Query\QuotesByAuthorQueryHandler;
use PhpSpec\ObjectBehavior;
use QuotesApi\Query\Result\QuotesByAuthorResult;

class QuotesByAuthorQueryHandlerSpec extends ObjectBehavior
{
    private const AUTHOR_SLUG = 'steve-jobs';

    function let(QuoteProvider $quoteProvider)
    {
        $this->beConstructedWith($quoteProvider);

        $quoteProvider->forAuthorWithLimit(self::AUTHOR_SLUG, 2)->willReturn([
            new Quote('Steve Jobs', 'THE ONLY WAY TO DO GREAT WORK IS TO LOVE WHAT YOU DO!'),
            new Quote('Steve Jobs', 'YOUR TIME IS LIMITED, SO DON’T WASTE IT LIVING SOMEONE ELSE’S LIFE!'),
        ]);
    }

    function it_fetches_quotes_from_provider_and_returns_as_a_result()
    {
        $query = new QuotesByAuthorQuery(self::AUTHOR_SLUG, 2);

        $result = $this->__invoke($query);

        $result->toArray()->shouldBe([
            'THE ONLY WAY TO DO GREAT WORK IS TO LOVE WHAT YOU DO!',
            'YOUR TIME IS LIMITED, SO DON’T WASTE IT LIVING SOMEONE ELSE’S LIFE!',
        ]);
    }
}
