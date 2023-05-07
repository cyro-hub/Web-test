<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method:*');
header("Access-Control-Allow-Headers:*");
header('Content-Type:application/json');

include_once '../Config/Repositories/ProductRepository.php';

$productRepo = new ProductRepository();

/// i used a post because of the 000webhost dont allow delete methods for free tier
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = json_decode(file_get_contents("php://input", true));

    $result = $productRepo->DeleteProducts($data);

    echo json_encode($result, true);
}
?>