<?php declare(strict_types=1);


namespace Src\Types;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;



require_once __DIR__ . '/../../vendor/autoload.php';


class Category extends ObjectType
{

    public function __construct()
    {
        parent::__construct([
            'name' => 'CategoryType',

            'fields' => [
                'id' => Type::int(),
                'title' => Type::string(),
            ],
        ]);
    }

}
