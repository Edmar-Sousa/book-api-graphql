<?php declare(strict_types=1);


namespace Src\Schema\Multation;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use PDO;

use Src\Models\CategoryModel;
use Src\Types\Category;

require_once __DIR__ . '/../../../vendor/autoload.php';


class CategoryMultation extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Category',
            'fields' => [
                'addCategory' => [
                    'type' => new Category(),

                    'args' => [
                        'title' => Type::nonNull(Type::string()),
                    ],

                    'resolve' => [$this, 'addCategory'],
                ],

                'updateCategory' => [
                    'type' => new Category(),

                    'args' => [
                        'id' => Type::nonNull(Type::int()),
                        'title' => Type::nonNull(Type::string()),
                    ],

                    'resolve' => [$this, 'updateCategory'],
                ],

                'deleteCategory' => [
                    'type' => new Category(),

                    'args' => [
                        'id' => Type::nonNull(Type::int()),
                    ],

                    'resolve' => [$this, 'deleteCategory'],
                ],
            ]
        ]);
    }


    public function addCategory($rootVal, array $args)
    {
        $categoryModel = new CategoryModel();

        $category = $categoryModel->addCategory([
            'title' => $args['title'],
        ]);

        return $category;
    }


    public function updateCategory($rootVal, array $args)
    {
        $categoryModel = new CategoryModel();

        $categoryUpdated = $categoryModel->updateCategory([
            'title' => $args['title'],
            'id' => $args['id'],
        ]);

        return $categoryUpdated;
    }


    public function deleteCategory($rootVal, array $args)
    {
        if (is_null($args['id']))
            return ['message' => 'Book id is required'];

        $categoryModel = new CategoryModel();

        $categoryDeleted = $categoryModel->deleteCategory($args['id']);

        return $categoryDeleted;
    }
}

