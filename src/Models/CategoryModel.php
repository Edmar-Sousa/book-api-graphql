<?php declare(strict_types=1);


namespace Src\Models;

use Src\Database\Conection;

require_once __DIR__ . '/../../vendor/autoload.php';


class CategoryModel
{

    public function addCategory(array $dataCategory)
    {
        $insertCategorySql = 'INSERT INTO categories(title) VALUES (:title)';

        $connection = new Conection();

        $connection->prepareQuery($insertCategorySql);
        $connection->execute($dataCategory);

        $connection->closeConnection();
    }


    public function updateCategory(array $dataCategory)
    {
        $updateCategorySql = 'UPDATE categories SET title = :title WHERE id = :id';

        $connection = new Conection();

        $connection->prepareQuery($updateCategorySql);
        $connection->execute($dataCategory);
        $connection->closeConnection();

        return $this->getCategoryWithId($dataCategory['id']);
    }


    public function deleteCategory(string $id)
    {
        $deleteCategorySql = 'DELETE FROM categories WHERE id = :id';

        $categoryDeleted = $this->getCategoryWithId($id);

        $connection = new Conection();

        $connection->prepareQuery($deleteCategorySql);
        $connection->execute(['id' => $id]);
        $connection->closeConnection();

        return $categoryDeleted;
    }


    public function getAllCategory()
    {
        $selectCategorySql = 'SELECT * FROM categories';

        $connection = new Conection();
        $connection->prepareQuery($selectCategorySql);

        $categorys = $connection->fetchAll();
        $connection->closeConnection();

        return $categorys;
    }


    public function getCategoryWithId(string $id)
    {
        $selectCategorySql = 'SELECT * FROM categories WHERE id = :id';

        $connection = new Conection();
        $connection->prepareQuery($selectCategorySql);
        $connection->execute([
            'id' => $id,
        ]);

        $categorys = $connection->fetchOne();
        $connection->closeConnection();

        return $categorys;
    }


    public function searchCategory(string $search)
    {
        $searchCategorySql = 'SELECT * FROM categories WHERE title LIKE :search';

        $connection = new Conection();
        $connection->prepareQuery($searchCategorySql);
        $connection->execute([
            'search' => $search,
        ]);

        $categorys = $connection->fetchOne();
        $connection->closeConnection();

        return $categorys;
    }

}
