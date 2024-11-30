<?php
class Product {
    public $id;
    public $name;
    public $price;
    public $quantity;

    public function __construct($id, $name, $price, $quantity) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }
}
