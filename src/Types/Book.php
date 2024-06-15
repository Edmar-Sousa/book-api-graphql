<?php declare(strict_types=1);


namespace Src\Types;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;



require_once __DIR__ . '/../../vendor/autoload.php';


class Book extends ObjectType
{

    public function __construct()
    {
        parent::__construct([
            'name' => 'BookType',

            'fields' => [
                'id' => Type::int(),
                'title' => Type::string(),
                'description' => Type::string(),
                'year' => Type::string(),
                'author_id' => Type::int(),
                'category_id' => Type::int(),
            ]
        ]);
    }

}
