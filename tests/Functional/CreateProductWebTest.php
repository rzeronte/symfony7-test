<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateProductWebTest extends WebTestCase
{
    const string BEARER_TOKEN = 'Bearer admintoken';

    public function testCreateProductWithoutAuthMustUnauthorized(): void
    {
        $client = static::createClient();
        $client->request('POST', '/products');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testCreateProductWithBadNameMustFail(): void
    {
        $client = static::createClient();
        $client->request('POST', '/products', [], [], [
            'HTTP_AUTHORIZATION' => self::BEARER_TOKEN,
        ], json_encode([
            'name' => '',
            'description' => '',
            'price' => 0,
            'taxRate' => 4,
        ]));

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testCreateProductWithBadDescriptionMustFail(): void
    {
        $client = static::createClient();
        $client->request('POST', '/products', [], [], [
            'HTTP_AUTHORIZATION' => self::BEARER_TOKEN,
        ], json_encode([
            'name' => 'Name',
            'description' => '',
            'price' => 0,
            'taxRate' => 4,
        ]));

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testCreateProductWithBadPriceMustFail(): void
    {
        $client = static::createClient();
        $client->request('POST', '/products', [], [], [
            'HTTP_AUTHORIZATION' => self::BEARER_TOKEN,
        ], json_encode([
            'name' => 'Name',
            'description' => 'Description',
            'price' => 0,
            'taxRate' => 4,
        ]));

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testCreateProductWithBadTaxRateMustFail(): void
    {
        $client = static::createClient();
        $client->request('POST', '/products', [], [], [
            'HTTP_AUTHORIZATION' => self::BEARER_TOKEN,
        ], json_encode([
            'name' => 'Name',
            'description' => 'Description',
            'price' => 1,
            'taxRate' => 0,
        ]));

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testCreateProductWithRightBodyMustReturnSuccess(): void
    {
        $client = static::createClient();
        $client->request('POST', '/products', [], [], [
            'HTTP_AUTHORIZATION' => self::BEARER_TOKEN,
        ], json_encode([
            'name' => 'Name',
            'description' => 'Description',
            'price' => 100,
            'taxRate' => 4,
        ]));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
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
