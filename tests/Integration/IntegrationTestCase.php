<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use QuotesApi\Core\QueryBus\Query;
use QuotesApi\Core\QueryBus\QueryBus;
use QuotesApi\Core\QueryBus\Result;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class IntegrationTestCase extends KernelTestCase
{
    private $queryBus;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->queryBus = $kernel->getContainer()->get(QueryBus::class);
    }

    protected function query(Query $query): Result
    {
        return $this->queryBus->query($query);
    }
}
