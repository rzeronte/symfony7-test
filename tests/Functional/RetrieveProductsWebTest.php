<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RetrieveProductsWebTest extends WebTestCase
{

    public function testRetrieveProductsWithEmptyDatabaseMustReturnOk(): void
    {
        $client = static::createClient();
        $client->request('GET', '/products');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertEquals(json_encode([
            'data' => [],
            "page" => 1,
            "numResults" => 0,
            "numPages" => 0,
            "limit" => 10
        ]),  $client->getResponse()->getContent());
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
