<?php declare(strict_types=1);

namespace Src\Database;

use PDO;
use PDOStatement;
use RuntimeException;


class Conection
{

    protected PDO|null $connection;
    protected PDOStatement|null $stmt;



    public function __construct()
    {
        $this->connection = new PDO('mysql:host=localhost;dbname=graphql;', 'root', 'adminroot');
    }



    private function checkConection()
    {
        if (is_null($this->connection))
            throw new RuntimeException('Connection with database is closed');
    }


    private function checkStatement()
    {
        if (is_null($this->stmt))
            throw new RuntimeException('Statement is closed or nullable');
    }


    public function getConnection()
    {
        $this->checkConection();

        return $this->connection;
    }



    public function prepareQuery(string $sql)
    {
        $this->stmt = $this->getConnection()->prepare($sql, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY,
        ]);
    }


    public function execute(array $data = null)
    {
        $this->stmt->execute($data);
    }


    public function fetchOne()
    {
        $this->checkStatement();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function fetchAll()
    {
        $this->checkStatement();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function closeConnection()
    {
        $this->connection = null;
        $this->stmt = null;
    }
}
