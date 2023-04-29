<?php
include 'Product.php';
include 'IProduct.php';


class DVD extends Product implements IProduct{
    public $size;
    function __construct($productDto)
    {
        $this->name = $productDto->name;
        $this->sku = $productDto->sku;
        $this->price = $productDto->price;
        $this->size = $productDto->size;
        $this->productType = $productDto->productType;
    }
    public function setUnit()
    {
        $this->unit = "{$this->size}mb";
    }
}