<?php declare(strict_types=1);

namespace Src\Schema\Query;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use Src\Types\Category;
use Src\Models\CategoryModel;

require_once __DIR__ . '/../../../vendor/autoload.php';



class CategoryQuery extends ObjectType
{

    public function __construct()
    {
        parent::__construct([
            'name' => 'CategoryQuery',
            'fields' => [
                'listCategory' => [
                    'type' => Type::listOf(new Category()),

                    'resolve' => [$this, 'listCategory'],
                ],

                'getCategory' => [
                    'type' => new Category(),
                    'args' => [
                        'id' => Type::int(),
                    ],

                    'resolve' => [$this, 'getCategory'],
                ],

                'searchCategory' => [
                    'type' => Type::listOf(new Category()),
                    'args' => [
                        'search' => Type::string(),
                    ],

                    'resolve' => [$this, 'searchCategory'],
                ],
            ]
        ]);
    }


    public function listCategory($rootVal)
    {
        $categoryModel = new CategoryModel();

        return $categoryModel->getAllCategory();
    }



    public function getCategory($rootVal, array $args)
    {
        if (is_null($args['id']))
            return ['message' => 'category id is required'];


        $categoryModel = new CategoryModel();

        return $categoryModel->getCategoryWithId($args['id']);
    }



    public function searchCategory($rootVal, array $args)
    {
        $categoryModel = new CategoryModel();

        return $categoryModel->searchCategory('%' . $args['search'] . '%');
    }
}
