<?php

use PHPUnit\Framework\TestCase;
require '/../ProductController.php';
require '/../ProductRepository.php';

class ProductsControllerTest extends TestCase
{
    private $mockRepository;
    private $controller;

    protected function setUp(): void
    {
        $this->mockRepository = $this->createMock(ProductRepository::class);

        $this->controller = new ProductsController($this->mockRepository);
    }

    public function testCreateProductSuccess()
    {
        $data = ['name' => 'Test Product', 'price' => 50.00, 'quantity' => 10];

        $this->mockRepository->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn(true);

        $result = $this->controller->create($data);

        $this->assertTrue($result['success']);
        $this->assertEquals('Product created successfully', $result['message']);
    }

    public function testCreateProductValidationFails()
    {
        $data = ['name' => '', 'price' => -50.00, 'quantity' => -10];

        $this->mockRepository->expects($this->never())->method('create');

        $result = $this->controller->create($data);

        $this->assertFalse($result['success']);
        $this->assertEquals('Validation failed', $result['message']);
    }

    public function testDeleteProductSuccess()
    {
        $productId = 1;

        $this->mockRepository->expects($this->once())
            ->method('delete')
            ->with($productId)
            ->willReturn(true);

        $result = $this->controller->delete($productId);

        $this->assertTrue($result['success']);
        $this->assertEquals('Product deleted', $result['message']);
    }

    public function testDeleteProductNotFound()
    {
        $productId = 999;

        $this->mockRepository->expects($this->once())
            ->method('delete')
            ->with($productId)
            ->willReturn(false);

        $result = $this->controller->delete($productId);

        $this->assertFalse($result['success']);
        $this->assertEquals('Product not found', $result['message']);
    }

    public function testPurchaseProductSuccess()
    {
        $productId = 1;
        $userId = 1;
        $quantity = 3;

        $this->mockRepository->expects($this->once())
            ->method('purchase')
            ->with($productId, $userId, $quantity)
            ->willReturn(true);

        $result = $this->controller->purchase($productId, $userId, $quantity);

        $this->assertTrue($result['success']);
        $this->assertEquals('Purchase successful', $result['message']);
    }

    public function testPurchaseProductFails()
    {
        $productId = 1;
        $userId = 1;
        $quantity = 100;

        $this->mockRepository->expects($this->once())
            ->method('purchase')
            ->with($productId, $userId, $quantity)
            ->willReturn(false);

        $result = $this->controller->purchase($productId, $userId, $quantity);

        $this->assertFalse($result['success']);
        $this->assertEquals('Purchase failed', $result['message']);
    }
}
