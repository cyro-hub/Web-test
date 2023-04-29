<?php

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

        $stmt = $db->connection->prepare("delete from Products where id=?");

        $indexer = 0;

        $result = $db->delete($indexer, $stmt, $data);

        if ($result[0]) {
            echo json_encode($db->Load("select * from Products"), true);
        }
    } catch (Exception $ex) {
        echo json_encode("Unable to delete {$ex->getMessage()}", true);
    }
}