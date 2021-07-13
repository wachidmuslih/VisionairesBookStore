
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
    echo json_encode("Koneksi Gagal.");
    die("Koneksi gagal: " . mysqli_connect_error());
}

switch ($method) {
    case 'GET':
        if (!isset($_GET['id'])) {  
            $response = array(
                "statusMessage" => "Parameter salah",
                "statusCode" => 404
            );
            echo json_encode($response);
        }
        $book->id = $_GET['id'] ;
        try {
            $result = $book->getOne();
            if ($result) {
                $emp_arr = array(
                    "nama"     => $book->nama,
                    "kategori" => $book->kategori,
                    "penerbit" => $book->penerbit,
                    "penulis" => $book->penulis,
                    "harga"    => $book->harga,
                    "diskon"   => $book->diskon
                );

                http_response_code(200);

                $response = array(
                    "data" => $emp_arr,
                    "statusMessage" => "Buku ditemukan",
                    "statusCode" => 200
                );
                echo json_encode($response);
            } else {
                throw new Exception("Buku tidak ditemukan", 1);
            }
        } catch (\Exception $th) {
            http_response_code(404);
            $response = array(
                "statusMessage" => "Buku tidak ditemukan",
                "statusCode" => 404
            );
            echo json_encode($response);
        }
        break;
    case 'POST':
        echo implode('\r\n',$_POST);
        $book->nama     = $_REQUEST['nama'];
        $book->penulis  = $_REQUEST['penulis'];
        $book->kategori = $_REQUEST['kategori'];
        $book->penerbit = $_REQUEST['penerbit'];
        $book->harga    = $_REQUEST['harga'];
        $book->diskon   = $_REQUEST['diskon'];

        if ($book->create()) {
            http_response_code(200);
            $response = array(
                "statusMessage" => "Buku berhasil dibuat",
                "statusCode" => 200
            );
            echo json_encode($response);
        } else {
            http_response_code(404);
            $response = array(
                "statusMessage" => "Buku tidak berhasil dibuat",
                "statusCode" => 404
            );
            echo json_encode($response);
        }
        break;
}
