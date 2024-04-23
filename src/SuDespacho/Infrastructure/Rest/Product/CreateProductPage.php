<?php

namespace App\SuDespacho\Infrastructure\Rest\Product;

use App\Shared\Infrastructure\Rest\ApiCommandPage;
use App\SuDespacho\Application\Command\CreateProduct\CreateProductCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class CreateProductPage extends ApiCommandPage
{
    public const string BEARER_TOKEN = 'Bearer admintoken';

    /**
     * @throws \Throwable
     */
    public function __invoke(Request $request): JsonResponse
    {
        if (self::BEARER_TOKEN !== $request->headers->get('Authorization')) {
            return new JsonResponse(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $payload = json_decode($request->getContent(), false);

        $id = $payload->id ?? Uuid::v4();

        $this->dispatch(
            new CreateProductCommand(
                $id,
                $payload->name ?? '',
                $payload->description ?? '',
                $payload->price ?? 0,
                $payload->taxRate ?? 0,
            )
        );

        return new JsonResponse(['id' => $id], Response::HTTP_OK);
    }
}
