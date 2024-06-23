<?php declare(strict_types=1);

namespace Src\Schema\Multation;


use GraphQL\Error\UserError;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


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
                        'author_id' => Type::nonNull(Type::int()),
                        'category_id' => Type::nonNull(Type::int()),
                        'description' => Type::nonNull(Type::string()),
                        'year' => Type::nonNull(Type::string()),
                    ],

                    'resolve' => [$this, 'addBook'],
                ],

                'updateBook' => [
                    'type' => new Book(),

                    'args' => [
                        'id' => Type::nonNull(Type::int()),
                        'title' => Type::nonNull(Type::string()),
                        'author_id' => Type::nonNull(Type::int()),
                        'category_id' => Type::nonNull(Type::int()),
                        'description' => Type::nonNull(Type::string()),
                        'year' => Type::nonNull(Type::string()),
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

        $book = $bookModel->addBook([
            'title' => $args['title'],
            'description' => $args['description'],
            'year' => $args['year'],
            'author_id' => $args['author_id'],
            'category_id' => $args['category_id'],
        ]);

        return $book;
    }


    public function updateBook($rootVal, array $args)
    {
        $bookModel = new BookModel();

        $bookUpdated = $bookModel->updateBook([
            'title' => $args['title'],
            'description' => $args['description'],
            'year' => $args['year'],
            'author_id' => $args['author_id'],
            'category_id' => $args['category_id'],
            'id' => $args['id'],
        ]);

        return $bookUpdated;
    }


    public function deleteBook($rootVal, array $args)
    {
        if (is_null($args['id']))
            throw new UserError('O campo id é obrigatorio');

        $bookModel = new BookModel();

        return $bookModel->deleteBook($args['id']);
    }
}

