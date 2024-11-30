<?php

class ProductsController
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function create(array $data)
    {
        if (empty($data['name']) || $data['price'] <= 0 || $data['quantity'] < 0) {
            return ['success' => false, 'message' => 'Validation failed'];
        }

        $success = $this->productRepository->create('products',$data);
        return ['success' => $success, 'message' => $success ? 'Product created successfully' : 'Failed to create product'];
    }

    public function delete($id)
    {
        $success = $this->productRepository->delete('products',$id);
        return ['success' => $success, 'message' => $success ? 'Product deleted' : 'Product not found'];
    }

    public function purchase($productId, $userId, $quantity)
    {
        $success = $this->productRepository->purchaseProduct($productId, $userId, $quantity);
        return ['success' => $success, 'message' => $success ? 'Purchase successful' : 'Purchase failed'];
    }
}
