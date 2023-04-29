<?php
class Product
{
    protected $sku;
    protected $name;
    protected $price;
    protected $unit;
    protected $productType;
    protected $insertQuery = 'insert into products(sku,name,price,unit) values(?,?,?,?,?)';
    public function bindInsertParams($con)
    {
        $stmt = $con->prepare($this->insertQuery);
        $stmt->bind_param("ssss", $this->sku, $this->name, $this->price, $this->unit,$this->productType);

        return $stmt;
    }
}