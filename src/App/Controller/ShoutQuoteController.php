<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\ApiResponseFactory;
use QuotesApi\Core\QueryBus\QueryBus;
use QuotesApi\Query\Query\QuotesByAuthorQuery;
use QuotesApi\Query\Result\QuotesByAuthorResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ShoutQuoteController extends AbstractController
{
    private const MAX_QUOTES = 10;

    private $queryBus;
    private $apiResponseFactory;

    public function __construct(QueryBus $queryBus, ApiResponseFactory $apiResponseFactory)
    {
        $this->queryBus = $queryBus;
        $this->apiResponseFactory = $apiResponseFactory;
    }

    /**
     * @Route("/shout/{authorSlug}", name="app_api_shout_quote")
     */
    public function shoutQuote(Request $request, string $authorSlug): JsonResponse
    {
        $limit = (int) $request->query->get('limit', 1);

        if ($limit <= 0 || $limit >= self::MAX_QUOTES) {
            return $this->apiResponseFactory->error('Limit outside range');
        }

        /** @var QuotesByAuthorResult $result */
        $result = $this->queryBus->query(
            new QuotesByAuthorQuery($authorSlug, $limit)
        );

        return $this->apiResponseFactory->success($result->toArray());
    }
}
