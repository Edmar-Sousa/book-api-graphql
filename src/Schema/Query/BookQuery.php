<?php declare(strict_types=1);

namespace Src\Schema\Query;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


use Src\Types\Book;
use Src\Models\BookModel;



class BookQuery extends ObjectType
{

    public function __construct()
    {
        parent::__construct([
            'name' => 'BookQuery',
            'fields' => [
                'listBooks' => [
                    'type' => Type::listOf(new Book()),

                    'resolve' => [$this, 'listBooks'],
                ],

                'getBook' => [
                    'type' => new Book(),
                    'args' => [
                        'id' => Type::int(),
                    ],

                    'resolve' => [$this, 'getBook'],
                ],

                'searchBooks' => [
                    'type' => Type::listOf(new Book()),
                    'args' => [
                        'search' => Type::string(),
                    ],

                    'resolve' => [$this, 'searchBooks'],
                ],
            ]
        ]);
    }


    public function listBooks($rootVal)
    {
        $booksModel = new BookModel();

        return $booksModel->getAllBooks();
    }


    public function getBook($rootVal, array $args)
    {

        if (is_null($args['id']))
            return ['message' => 'The book id is required'];


        $booksModel = new BookModel();

        return $booksModel->getBookWithId($args['id']);
    }



    public function searchBooks($rootVal, array $args)
    {
        $booksModel = new BookModel();

        return $booksModel->searchBooksByText('%' . $args['search'] . '%');
    }
}
