<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../database.php';
include_once '../model/book.php';

$database = new Database();
$db = $database->getConnection();

$books = new Book($db);
$records = $books->getAll();
$bookCount = $records->num_rows;

if ($bookCount > 0) {
    $bookArr = array();
    $bookArr["data"] = array();
    $bookArr["itemCount"] = $bookCount;
    while ($row = $records->fetch_assoc()) {
        array_push($bookArr["data"], $row);
    }
    echo json_encode($bookArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "Tidak ada data.")
    );
}
