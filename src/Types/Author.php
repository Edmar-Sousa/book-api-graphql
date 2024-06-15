<?php declare(strict_types=1);


namespace Src\Types;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;



require_once __DIR__ . '/../../vendor/autoload.php';


class Author extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'type' => 'AuthorType',

            'fields' => [
                'id' => Type::int(),
                'name' => Type::string(),
                'bio' => Type::string(),
            ]
        ]);
    }
}
