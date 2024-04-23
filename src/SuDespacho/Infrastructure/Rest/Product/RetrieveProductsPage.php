<?php

namespace App\SuDespacho\Infrastructure\Rest\Product;

use App\Shared\Infrastructure\Rest\ApiQueryPage;
use App\SuDespacho\Application\Query\RetrieveProducts\RetrieveProductsQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RetrieveProductsPage extends ApiQueryPage
{
    /**
     * @throws \Throwable
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->ask(
            new RetrieveProductsQuery(
                $request->query->getString('name'),
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 10),
            )
        );

        return new JsonResponse($result, Response::HTTP_OK);
    }
}
