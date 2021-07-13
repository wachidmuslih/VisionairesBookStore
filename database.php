<?php
class Database
{
    private $host = "localhost";
    private $db_name = "visionairesbookstore";
    private $username = "root";
    private $password = "";
    public $db;
    public function getConnection()
    {
        $this->db = null;
        try {
            $this->db = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        } catch (Exception $e) {
            return false;
        }
        return $this->db;
    }
}
?>
