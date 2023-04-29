<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method:*');
header("Access-Control-Allow-Headers: *");
header('Content-Type:application/json');

include '../DataLibrary/Database.php';
include_once '../Config/AutoLoader.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $data = json_decode(file_get_contents("php://input", true));

        $arr = (array) $data;

        if (!$arr) {
            echo json_encode("Empty body", true);
            return;
        }

        foreach ($data as $key => $value) {
            if ($key == null || $value == null || $key == '' || $value == '') {
                echo json_encode(['message' => "{$key} value not define", 'status' => false], true);
                return;
            }
        }

        $product = new $data->productType($data);
        $product->setUnit();
        $stmt = $product->bindInsertParams($db->connection);
        $result = $db->Save($stmt);

        echo json_encode(['message' => 'Product added successfully', 'status' => $result], true);

    } catch (Exception $ex) {
        echo json_encode("unable to save product {$ex->getMessage()}", true);
    }
}



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $results = $db->Load('select * from Products');

        echo json_encode($results, true);
    } catch (Exception $ex) {
        echo json_encode("Error occured accessing the database {$ex->getMessage()}", true);
    }
}
?>