<?php

namespace App\Tests\Infrastructure\Controller;

use App\Infrastructure\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testCreateProduct_Successful()
    {
        $productCode = 'PRD_1';
        $productTitle = 'Продукт 1';
        $requestData = [
            'title' => $productTitle,
            'code' => $productCode,
        ];

        $this->client->request(
            'POST',
            '/api/products',
            [],
            [],
            [],
            json_encode($requestData)
        );

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        // ответ сервера ['id' => ...]
        $createdProductId  = $content['id'];

        /** @var ProductRepository $productRepository */
        $productRepository = self::$container->get(ProductRepository::class);
        $productFound = $productRepository->find($createdProductId);

        $this->assertEquals($productTitle, $productFound->getTitle());
        $this->assertEquals($productCode, $productFound->getCode());

        // with validation error with uniq code
        $this->client->request(
            'POST',
            '/api/products',
            [],
            [],
            [],
            json_encode($requestData)
        );
        $response = $this->client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('code', $content['errors']);

        // with empty data
        $this->client->request(
            'POST',
            '/api/products',
            [],
            [],
            []
        );
        $response = $this->client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('code', $content['errors']);
        $this->assertArrayHasKey('title', $content['errors']);
    }
}
