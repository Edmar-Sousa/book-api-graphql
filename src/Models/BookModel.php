<?php declare(strict_types=1);

namespace Src\Models;

use Src\Database\Conection;



class BookModel
{

    private function getBookLatestInserted(Conection $conection)
    {
        $latestBookInsertedSql = 'SELECT * FROM books WHERE id = LAST_INSERT_ID()';

        $conection->prepareQuery($latestBookInsertedSql);
        $conection->execute();

        return $conection->fetchOne();
    }


    public function addBook(array $bookData)
    {
        $insertBookSql = <<<SQL
            INSERT INTO books(
                title,
                description,
                year,
                author_id,
                category_id
            )
            VALUES (
                :title,
                :description,
                :year,
                :author_id,
                :category_id 
            )
        SQL;

        $connection = new Conection();
        $connection->prepareQuery($insertBookSql);
        $connection->execute($bookData);

        $lastBookInserted = $this->getBookLatestInserted($connection);

        $connection->closeConnection();

        return $lastBookInserted;
    }


    public function updateBook(array $bookData)
    {
        $updateBookSql = <<<SQL
            UPDATE books 
            SET title = :title,
                description = :description,
                year = :year,
                author_id = :author_id,
                category_id = :category_id
            WHERE id = :id
        SQL;

        $connection = new Conection();
        $connection->prepareQuery($updateBookSql);
        $connection->execute($bookData);

        $connection->closeConnection();

        return $this->getBookWithId($bookData['id']);
    }


    public function deleteBook(int $id)
    {
        $deleteBookSql = 'DELETE FROM books WHERE id = :id';

        $bookDeleted = $this->getBookWithId($id);

        $connection = new Conection();
        $connection->prepareQuery($deleteBookSql);
        $connection->execute([
            'id' => $id,
        ]);

        $connection->closeConnection();

        return $bookDeleted;
    }


    public function getBookWithId(int $id)
    {
        $selectWithIdSql = 'SELECT * FROM books WHERE id = :id';

        $connection = new Conection();
        $connection->prepareQuery($selectWithIdSql);
        $connection->execute([
            'id' => $id
        ]);

        $book = $connection->fetchOne();
        $connection->closeConnection();

        return $book;
    }



    public function searchBooksByText(string $search)
    {
        $searchSelectSql = <<<SQL
            SELECT 
                *
            FROM books
            WHERE books.title LIKE :search
        SQL;


        $connection = new Conection();
        $connection->prepareQuery($searchSelectSql);
        $connection->execute([
            'search' => $search
        ]);

        $books = $connection->fetchAll();
        $connection->closeConnection();

        return $books;
    }


    public function getAllBooks()
    {
        $getAllBooksSql = 'SELECT * FROM books';

        $connection = new Conection();
        $connection->prepareQuery($getAllBooksSql);
        $connection->execute();

        $books = $connection->fetchAll();
        $connection->closeConnection();

        return $books;
    }
}

