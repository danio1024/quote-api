<?php

declare(strict_types=1);

namespace App\Tests\Integration\QuotesApi\Query;

use App\Tests\Integration\IntegrationTestCase;
use QuotesApi\Query\Query\QuotesByAuthorQuery;

final class QuotesByAuthorQueryTest extends IntegrationTestCase
{
    public function testFetchingSingleQuote()
    {
        $result = $this->query(new QuotesByAuthorQuery(
            'steve-jobs'
        ));

        $this->assertCount(1, $result->quotes());
    }
}
