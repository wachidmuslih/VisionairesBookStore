
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../database.php';
include_once '../model/book.php';

$database = new Database();
$db = $database->getConnection();
$book = new Book($db);
$method = $_SERVER['REQUEST_METHOD'];


if (!$db) {
    http_response_code(404);
    $response = array(
        "statusMessage" => "Koneksi Gagal.",
        "statusCode" => 400
    );
    echo json_encode($response);
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {  
    $response = array(
        "statusMessage" => "Parameter salah",
        "statusCode" => 404
    );
    echo json_encode($response);
}
$received_data = json_decode(file_get_contents("php://input"));
$book->id       = isset($_GET['id']) ? $_GET['id'] : die();
$book->nama     = $_GET['nama'];
$book->kategori = $_GET['kategori'];
$book->penulis  = $_GET['penulis'];
$book->penerbit = $_GET['penerbit'];
$book->harga    = $_GET['harga'];
$book->diskon   = $_GET['diskon'];
if ($book->update()) {
    http_response_code(200);
    $response = array(
        "statusMessage" => "Buku berhasil diperbarui",
        "statusCode" => 200
    );
    echo json_encode($response);
} else {
    http_response_code(404);
    $response = array(
        "statusMessage" => "Buku tidak berhasil diperbarui",
        "statusCode" => 404
    );
    echo json_encode($response);
}
