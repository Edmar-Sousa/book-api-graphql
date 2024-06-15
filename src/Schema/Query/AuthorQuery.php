<?php declare(strict_types=1);

namespace Src\Schema\Query;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


use Src\Models\AuthorModel;
use Src\Types\Author;

require_once __DIR__ . '/../../../vendor/autoload.php';



class AuthorQuery extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'AuthorQuery',
            'fields' => [
                'getAuthor' => [
                    'type' => new Author(),
                    'args' => [
                        'id' => Type::int(),
                    ],

                    'resolve' => [$this, 'getAuthor'],
                ],

                'listAuthors' => [
                    'type' => Type::listOf(new Author()),
                    'resolve' => [$this, 'listAuthors'],
                ],

                'searchAuthors' => [
                    'type' => Type::listOf(new Author()),
                    'args' => [
                        'search' => Type::string(),
                    ],

                    'resolve' => [$this, 'searchAuthors'],
                ],
            ]
        ]);
    }


    public function getAuthor($rootVal, array $args)
    {
        if (is_null($args['id']))
            return ['message' => 'author id is required'];

        $authorModel = new AuthorModel();

        return $authorModel->getAuthorWithId($args['id']);
    }



    public function listAuthors($rootVal, array $args)
    {
        $authorModel = new AuthorModel();

        return $authorModel->getAllAuthors();
    }


    public function searchAuthors($rootVal, array $args)
    {
        $authorModel = new AuthorModel();

        return $authorModel->searchAuthor('%' . $args['search'] . '%');
    }
}

