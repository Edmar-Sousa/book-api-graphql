<?php declare(strict_types=1);

namespace Src\Test;

require_once __DIR__ . '/../../vendor/autoload.php';


use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;


use Src\Schema\Multation\BookMultation;
use Src\Schema\Query\BookQuery;
use Src\Traits\AssertArray;


class BookQueryTest extends TestCase
{

    use AssertArray;
    protected Schema $bookSchema;


    protected function setUp(): void
    {

        $this->bookSchema = new Schema(
            (new SchemaConfig())
                ->setQuery(new BookQuery())
                ->setMutation(new BookMultation())
        );

    }



    public function testAddBook()
    {
        $query = 'mutation {
            addBook (
                title: "Livro Mock",
                description: "Livro Mock para teste",
                year: "2024-06-02",
                author_id: 1,
                category_id: 1
            ) {
                id
                title
                description
                year
                author_id
                category_id
            }
        }';


        $result = GraphQL::executeQuery($this->bookSchema, $query);
        $output = $result->toArray();

        $expected = [
            'addBook' => [
                'id' => $output['data']['addBook']['id'],
                'title' => 'Livro Mock',
                'description' => 'Livro Mock para teste',
                'year' => '2024-06-02',
                'author_id' => 1,
                'category_id' => 1,
            ]
        ];


        $this->assertEquals($expected, $output['data']);

        return $output['data']['addBook']['id'];
    }


    #[Depends('testAddBook')]
    public function testListBooks($bookId)
    {
        $query = '{ 
            listBooks {
                id
                title
                description
                year
                author_id
                category_id
            }
        }';


        $result = GraphQL::executeQuery($this->bookSchema, $query);
        $output = $result->toArray();

        $books = $output['data']['listBooks'];

        $expected = [
            'id' => $bookId,
            'title' => 'Livro Mock',
            'description' => 'Livro Mock para teste',
            'year' => '2024-06-02',
            'author_id' => 1,
            'category_id' => 1,
        ];

        $this->assertArrayContains($expected, $books, $this);
    }


    #[Depends('testAddBook')]
    public function testGetBook($bookId)
    {
        $query = "{ 
            getBook (id: $bookId) {
                id
                title
                description
                year
                author_id
                category_id
            }
        }";


        $result = GraphQL::executeQuery($this->bookSchema, $query);
        $output = $result->toArray();


        $expected = [
            'getBook' => [
                'id' => $bookId,
                'title' => 'Livro Mock',
                'description' => 'Livro Mock para teste',
                'year' => '2024-06-02',
                'author_id' => 1,
                'category_id' => 1,
            ]
        ];

        $this->assertEquals($expected, $output['data']);
    }


    #[Depends('testAddBook')]
    public function testSearchBook($bookId)
    {
        $query = '{ 
            searchBooks (search: "Livro Mock") {
                id
                title
                description
                year
                author_id
                category_id
            }
        }';


        $result = GraphQL::executeQuery($this->bookSchema, $query);
        $output = $result->toArray();

        $books = $output['data']['searchBooks'];

        $expected = [
            'id' => $bookId,
            'title' => 'Livro Mock',
            'description' => 'Livro Mock para teste',
            'year' => '2024-06-02',
            'author_id' => 1,
            'category_id' => 1,
        ];

        $this->assertArrayContains($expected, $books, $this);
    }


    #[Depends('testAddBook')]
    public function testUpdateBook($bookId)
    {
        $query = "mutation {
            updateBook (
                id: $bookId,
                title: \"Teste update book\",
                author_id: 1,
                category_id: 1,
                description: \"Descricao update book\",
                year: \"2024-06-02\"
            ) {
                id
                title
                author_id
                category_id
                description
                year
            }
        }";

        $result = GraphQL::executeQuery($this->bookSchema, $query);
        $output = $result->toArray();


        $expected = [
            'updateBook' => [
                'id' => $bookId,
                'title' => 'Teste update book',
                'description' => 'Descricao update book',
                'year' => '2024-06-02',
                'author_id' => 1,
                'category_id' => 1,
            ]
        ];

        $this->assertEquals($expected, $output['data']);

    }


    #[Depends('testAddBook')]
    public function testDeleteBook($bookId)
    {
        $query = "mutation {
            deleteBook(id: $bookId) {
                id
                title
                description
                year
                author_id
                category_id
            }
        }";

        $result = GraphQL::executeQuery($this->bookSchema, $query);
        $output = $result->toArray();


        $expected = [
            'deleteBook' => [
                'id' => $bookId,
                'title' => 'Teste update book',
                'description' => 'Descricao update book',
                'year' => '2024-06-02',
                'author_id' => 1,
                'category_id' => 1,
            ]
        ];

        $this->assertEquals($expected, $output['data']);
    }
}
