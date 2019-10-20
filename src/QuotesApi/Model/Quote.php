<?php

declare(strict_types=1);

namespace QuotesApi\Model;

final class Quote
{
    private $author;
    private $quote;

    public function __construct(string $author, string $quote)
    {
        $this->author = $author;
        $this->quote = $quote;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function quote(): string
    {
        return $this->quote;
    }
}
