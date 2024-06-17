<?php declare(strict_types=1);

namespace Src\Models;

use Src\Database\Conection;

require_once __DIR__ . '/../../vendor/autoload.php';



class AuthorModel
{

    private function gatLatestAuthorInserted(Conection &$conection)
    {
        $lastIdInserted = 'SELECT * FROM authors WHERE id = ()';

        $conection->prepareQuery($lastIdInserted);
        $conection->execute();

        $latestAuthor = $conection->fetchOne();

        return $latestAuthor;
    }

    public function addAuthor(array $authorData)
    {
        $insertAuthorSql = <<<SQL
            INSERT INTO authors (
                name,
                bio
            ) VALUES (:name, :bio)
        SQL;

        $connection = new Conection();
        $connection->prepareQuery($insertAuthorSql);
        $connection->execute($authorData);

        $authorCreated = $this->gatLatestAuthorInserted($connection);

        $connection->closeConnection();

        return $authorCreated;
    }



    public function updateAuthor(array $authorData)
    {
        $updateAuthorSql = <<<SQL
            UPDATE authors 
            SET 
                name = :name,
                bio = :bio
            WHERE id = :id
        SQL;

        $connection = new Conection();
        $connection->prepareQuery($updateAuthorSql);
        $connection->execute($authorData);

        $connection->closeConnection();

        return $this->getAuthorWithId($authorData['id']);
    }


    public function deleteAuthor(int $id)
    {
        $authorToDelete = $this->getAuthorWithId($id);

        $deleteAuthorSql = 'DELETE FROM authors WHERE id = ?';

        $connection = new Conection();
        $connection->prepareQuery($deleteAuthorSql);
        $connection->execute(['id' => $id]);

        $connection->closeConnection();

        return $authorToDelete;
    }

    public function getAuthorWithId(int|string $id)
    {
        $selectAuthorSql = 'SELECT * FROM authors WHERE id = :id';

        $connection = new Conection();
        $connection->prepareQuery($selectAuthorSql);
        $connection->execute([
            'id' => $id
        ]);

        $author = $connection->fetchOne();
        $connection->closeConnection();

        return $author;
    }


    public function searchAuthor(string $search)
    {
        $selectAuthorSql = 'SELECT * FROM authors WHERE name LIKE :search';

        $connection = new Conection();
        $connection->prepareQuery($selectAuthorSql);
        $connection->execute([
            'search' => $search
        ]);

        $author = $connection->fetchAll();
        $connection->closeConnection();

        return $author;
    }

    public function getAllAuthors()
    {
        $selectAllAuthorSql = 'SELECT * FROM authors';

        $connection = new Conection();
        $connection->prepareQuery($selectAllAuthorSql);
        $connection->execute();

        $author = $connection->fetchAll();
        $connection->closeConnection();

        return $author;
    }
}