<?php
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

if (!isset($_GET['id'])) {
    $response = array(
        "statusMessage" => "Parameter salah",
        "statusCode" => 404
    );
    echo json_encode($response);
}
$book->id = $_GET['id'];
try {
    $result = $book->getOne();
    if ($result) {
        $emp_arr = array(
            "nama"     => $book->nama,
            "kategori" => $book->kategori,
            "penerbit" => $book->penerbit,
            "penulis"  => $book->penulis,
            "harga"    => $book->harga,
            "diskon"   => $book->diskon
        );

?>
        <h1><?= $book->nama ?></h1>
        <h2><?= $book->kategori ?></h2>
        <h3><?= $book->penerbit ?></h3>
        <h3><?= $book->penulis ?></h3>
        <h3><?= $book->harga ?></h3>
        <h3><?= $book->diskon ?></h3>



<?php
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
