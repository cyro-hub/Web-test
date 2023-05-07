<?php
include_once 'IProductRepository.php';
include_once '../DataLibrary/DataAccess.php';
include_once '../DataLibrary/Database.php';
include '../Config/AutoLoader.php';
class ProductRepository implements IProductInterface
{
    private $connection;
    private $dataAccess;
    private $data;
    private $readProducts = 'select * from Products';
    private $insertProduct = 'insert into products(sku,name,price,unit,productType) values(?,?,?,?,?)';
    private $deleteProduct = "delete from Products where id=?";
    public function __construct()
    {
        $this->connection = (new Database())->Connect();
        $this->dataAccess = (new DataAccess());
    }
    public function SaveProduct($data)
    {
        try {
            $product = new $data->productType($data);

            $product->setUnit();

            $stmt = $this->connection->prepare($this->insertProduct);

            $stmt->bind_param("sssss", $product->sku, $product->name, $product->price, $product->unit, $product->productType);

            $result = $this->dataAccess->Save($stmt);

            $this->data = ["data" => [], "message" => "Added product successfully", "isSuccess" => true];

            return $this->data;

        } catch (Exception $ex) {
            $this->data = ["data" => [], "message" => $ex->getMessage(), "isSuccess" => false];

            return $this->data;
        }
    }
    public function GetProduct()
    {
        try {
            $results = $this->dataAccess->Load($this->connection, $this->readProducts);

            $this->data = ["data" => $results, "message" => "Read product successfully", "isSuccess" => true];

            return $this->data;
        } catch (Exception $ex) {

            $this->data = ["data" => [], "message" => $ex->getMessage(), "isSuccess" => false];

            return $this->data;
        }
    }
    public function deleteProducts($data)
    {
        try {
            $stmt = $this->connection->prepare($this->deleteProduct);

            $indexer = 0;

            $deletedProducts = [];

            $this->deleteProduct($indexer, $stmt, (array) $data, $deletedProducts);

            $results = $this->dataAccess->Load($this->connection, $this->readProducts);

            $this->data = ["data" => $results, "deletedProducts" => $deletedProducts, "message" => "Deleted product successfully", "isSuccess" => true];

            return $this->data;
        } catch (Exception $ex) {
            $this->data = ["data" => [], "message" => $ex->getMessage(), "isSuccess" => false];

            return $this->data;
        }
    }
    private function deleteProduct($indexer, $stmt, $data, &$deletedProducts)
    {
        $id = $data[$indexer];
        $stmt->bind_param("s", $id);

        if ($this->dataAccess->Save($stmt))
            $deletedProducts[$indexer] = $id;

        $indexer++;

        if ($indexer < sizeof($data))
            $this->deleteProduct($indexer, $stmt, $data, $deletedProducts);
    }
}

?>