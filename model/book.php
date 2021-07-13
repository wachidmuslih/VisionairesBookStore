<?php
class Book
{

    private $db;

    private $db_table = "books";

    public $id;
    public $nama;
    public $kategori;
    public $penerbit;
    public $penulis;
    public $harga;
    public $diskon;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getOne()
    {
        $sqlQuery = "SELECT nama, kategori, penulis, penerbit, harga, diskon FROM " . $this->db_table . " WHERE id = " . $this->id;
        $record = $this->db->query($sqlQuery);
        $dataRow = $record->fetch_assoc();
        if ($dataRow != null) {
            $this->nama     = $dataRow['nama'];
            $this->penulis  = $dataRow['penulis'];
            $this->kategori = $dataRow['kategori'];
            $this->penerbit = $dataRow['penerbit'];
            $this->harga    = $dataRow['harga'];
            $this->diskon   = $dataRow['diskon'];
            return true;
        } else {
            return false;
        }
    }

    public function getAll()
    {
        $sqlQuery = "SELECT id, nama, kategori, penerbit, penulis, harga, diskon FROM " . $this->db_table . "";
        $this->result = $this->db->query($sqlQuery);
        return $this->result;
    }

    public function create()
    {

        $this->nama     = htmlspecialchars(strip_tags($this->nama));
        $this->kategori = htmlspecialchars(strip_tags($this->kategori));
        $this->penulis  = htmlspecialchars(strip_tags($this->penulis));
        $this->penerbit = htmlspecialchars(strip_tags($this->penerbit));
        $this->harga    = htmlspecialchars(strip_tags($this->harga));
        $this->diskon   = htmlspecialchars(strip_tags($this->diskon));
        $sqlQuery = "INSERT INTO "   . $this->db_table   . " SET " .
            " nama      = '" . $this->nama       . "', " .
            " kategori  = '" . $this->kategori   . "', " .
            " penulis   = '" . $this->penulis    . "', " .
            " penerbit  = '" . $this->penerbit   . "', " .
            " harga     = '" . $this->harga      . "', " .
            " diskon    = '" . $this->diskon     . "'";
        $this->db->query($sqlQuery);
        if ($this->db->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function update()
    {

        $this->id       = htmlspecialchars(strip_tags($this->id));
        $this->nama     = htmlspecialchars(strip_tags($this->nama));
        $this->kategori = htmlspecialchars(strip_tags($this->kategori));
        $this->penulis  = htmlspecialchars(strip_tags($this->penulis));
        $this->penerbit = htmlspecialchars(strip_tags($this->penerbit));
        $this->harga    = htmlspecialchars(strip_tags($this->harga));
        $this->diskon   = htmlspecialchars(strip_tags($this->diskon));


        $sqlQuery = "UPDATE " . $this->db_table . " SET " .
            "nama     = '" . $this->nama        . "', " .
            "kategori = '" . $this->kategori    . "', " .
            "penulis = '"  . $this->penulis    . "', " .
            "penerbit = '" . $this->penerbit    . "', " .
            "harga    = '" . $this->harga       . "', " .
            "diskon   = '" . $this->diskon      . "'  " .
            "WHERE id = " . $this->id;

        $this->db->query($sqlQuery);
        if ($this->db->affected_rows > 0) {
            return true;
        }
        return false;
    }

    function delete()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = " . $this->id;
        $this->db->query($sqlQuery);
        if ($this->db->affected_rows > 0) {
            return true;
        }
        return false;
    }

    function sanitize(){
        
    }
}
