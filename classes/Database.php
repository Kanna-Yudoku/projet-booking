<?php
class Database {
    private string $host = 'localhost';
    private string $dbName = 'structure_bdd';
    private string $user = 'root';
    private string $password = '';
    private ?PDO $pdo = null;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName};charset=utf8",
                $this->user,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}
