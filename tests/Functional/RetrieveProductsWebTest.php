<?php

namespace App\Tests\Functional;

use App\SuDespacho\Application\Query\RetrieveProducts\RetrieveProductsResponse;
use App\SuDespacho\Infrastructure\Persistence\Doctrine\Repository\DoctrineProductRepository;
use Doctrine\ORM\Query\QueryException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RetrieveProductsWebTest extends WebTestCase
{
    /**
     * @throws QueryException
     */
    public function testRetrieveProductsWithEmptyDatabaseMustReturnOk(): void
    {
        $client = static::createClient();
        $client->request('GET', '/products');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $productRepository = new DoctrineProductRepository($this->getContainer()->get('doctrine.orm.entity_manager'));

        $currentProductsResponse = RetrieveProductsResponse::from(
            $productRepository->search(null, null, null),
            1,
            10,
            $productRepository->searchCount(null, null, null)
        );

        $this->assertEquals(json_encode([
            'data' => $currentProductsResponse->results(),
            'page' => $currentProductsResponse->page(),
            'numResults' => $currentProductsResponse->numResults(),
            'numPages' => $currentProductsResponse->numPages(),
            'limit' => $currentProductsResponse->limit(),
        ]), $client->getResponse()->getContent());
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->restoreExceptionHandler();
    }

    protected function restoreExceptionHandler(): void
    {
        while (true) {
            $previousHandler = set_exception_handler(static fn () => null);

            restore_exception_handler();

            if (null === $previousHandler) {
                break;
            }

            restore_exception_handler();
        }
    }
}
