<?php
include 'Product.php';
include 'IProduct.php';


class Furniture extends Product implements IProduct
{
    public $length;
    public $width;
    public $height;
    function __construct($productDto)
    {
        $this->name = $productDto->name;
        $this->sku = $productDto->sku;
        $this->price = $productDto->price;
        $this->length = $productDto->length;
        $this->width = $productDto->width;
        $this->height = $productDto->height;
        $this->productType = $productDto->productType;
    }
    public function setUnit()
    {
        $this->unit = "{$this->length}x{$this->width}x{$this->height}";
    }
}