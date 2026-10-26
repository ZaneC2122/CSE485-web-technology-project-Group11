<?php
class DBConnection
{
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $conn;

    public function __construct()
    {
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        $this->dbname = DB_NAME;

        $sqlStr = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4";
        $this->conn = new PDO($sqlStr, $this->user, $this->pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // UPDATE giu nguyen gia tri thi rowCount van tinh la matched
            PDO::MYSQL_ATTR_FOUND_ROWS   => true,
        ]);
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
