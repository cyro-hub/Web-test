<?php
include 'Product.php';
include 'IProduct.php';
class Book extends Product implements IProduct
{
    public $weight;
    function __construct($productDto)
    {
        $this->name = $productDto->name;
        $this->sku = $productDto->sku;
        $this->price = $productDto->price;
        $this->weight = $productDto->weight;
        $this->productType = $productDto->productType;
    }
    public function setUnit()
    {
        $this->unit = "{$this->weight}Kg";
    }
}