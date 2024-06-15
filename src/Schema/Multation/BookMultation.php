<?php declare(strict_types=1);

namespace Src\Schema\Multation;

require_once __DIR__ . '/../../../vendor/autoload.php';



use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use PDO;

use Src\Models\BookModel;
use Src\Types\Book;


class BookMultation extends ObjectType
{

    public function __construct()
    {
        parent::__construct([
            'name' => 'Book',
            'fields' => [
                'addBook' => [
                    'type' => new Book(),

                    'args' => [
                        'title' => Type::nonNull(Type::string()),
                        'authorId' => Type::nonNull(Type::string()),
                        'categoryId' => Type::nonNull(Type::string()),
                        'description' => Type::nonNull(Type::string()),
                        'publishedYear' => Type::nonNull(Type::string()),
                    ],

                    'resolve' => [$this, 'addBook'],
                ],

                'updateBook' => [
                    'type' => new Book(),

                    'args' => [
                        'id' => Type::nonNull(Type::int()),
                        'title' => Type::nonNull(Type::string()),
                        'authorId' => Type::nonNull(Type::string()),
                        'categoryId' => Type::nonNull(Type::string()),
                        'description' => Type::nonNull(Type::string()),
                        'publishedYear' => Type::nonNull(Type::string()),
                    ],

                    'resolve' => [$this, 'updateBook'],
                ],


                'deleteBook' => [
                    'type' => new Book(),

                    'args' => [
                        'id' => Type::nonNull(Type::int()),
                    ],

                    'resolve' => [$this, 'deleteBook'],
                ],
            ]
        ]);
    }



    public function addBook($rootVal, array $args)
    {
        $bookModel = new BookModel();

        $bookModel->addBook([
            'title' => $args['title'],
            'description' => $args['description'],
            'year' => $args['publishedYear'],
            'author_id' => $args['authorId'],
            'category_id' => $args['categoryId'],
        ]);

        return [
            'title' => $args['title'],
            'description' => $args['description'],

            'year' => $args['publishedYear'],
            'author_id' => $args['authorId'],
            'category_id' => $args['categoryId'],
        ];
    }


    public function updateBook($rootVal, array $args)
    {
        $bookModel = new BookModel();

        $bookUpdated = $bookModel->updateBook([
            'title' => $args['title'],
            'description' => $args['description'],
            'year' => $args['publishedYear'],
            'author_id' => $args['authorId'],
            'category_id' => $args['categoryId'],
            'id' => $args['id'],
        ]);

        return $bookUpdated;
    }


    public function deleteBook($rootVal, array $args)
    {
        if (is_null($args['id']))
            return ['message' => 'Book id is required'];

        $bookModel = new BookModel();

        return $bookModel->deleteBook($args['id']);
    }
}

