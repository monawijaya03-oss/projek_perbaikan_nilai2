<?php

class Database
{
    private $host = "localhost";
    private $dbname = "db_akademik";
    private $username = "root";
    private $password = "";

    public function getConnection()
    {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return $pdo;

        } catch (PDOException $e) {
            // Detail error hanya masuk log server, tidak ditampilkan ke pengguna
            error_log($e->getMessage());
            die("Koneksi database gagal. Periksa konfigurasi config/Database.php dan pastikan MySQL berjalan.");
        }
    }
}
