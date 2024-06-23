<?php declare(strict_types=1);


namespace Src\Schema\Multation;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use Src\Types\Author;
use Src\Models\AuthorModel;



class AuthorMultation extends ObjectType
{

    public function __construct()
    {
        parent::__construct([
            'name' => 'Author',
            'fields' => [
                'addAuthor' => [
                    'type' => new Author(),

                    'args' => [
                        'name' => Type::nonNull(Type::string()),
                        'bio' => Type::nonNull(Type::string()),
                    ],

                    'resolve' => [$this, 'addAuthor'],
                ],

                'updateAuthor' => [
                    'type' => new Author(),

                    'args' => [
                        'id' => Type::nonNull(Type::int()),
                        'name' => Type::nonNull(Type::string()),
                        'bio' => Type::nonNull(Type::string()),
                    ],

                    'resolve' => [$this, 'updateAuthor'],
                ],

                'deleteAuthor' => [
                    'type' => new Author(),

                    'args' => [
                        'id' => Type::nonNull(Type::int()),
                    ],

                    'resolve' => [$this, 'deleteAuthor'],
                ],
            ]
        ]);
    }


    public function addAuthor($rootVal, array $args)
    {
        $authorModel = new AuthorModel();

        $author = $authorModel->addAuthor([
            'name' => $args['name'],
            'bio' => $args['bio'],
        ]);

        return $author;
    }


    public function updateAuthor($rootVal, array $args)
    {
        $authorModel = new AuthorModel();

        $authorUpdated = $authorModel->updateAuthor([
            'name' => $args['name'],
            'bio' => $args['bio'],
            'id' => $args['id'],
        ]);

        return $authorUpdated;
    }


    public function deleteAuthor($rootVal, array $args)
    {
        if (is_null($args['id']))
            return ['message' => 'category id is required'];


        $authorModel = new AuthorModel();
        $deletedAuthor = $authorModel->deleteAuthor($args['id']);

        return $deletedAuthor;
    }
}

