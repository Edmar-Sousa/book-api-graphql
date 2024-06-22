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

        $expected = [
            'listBooks' => [
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


    public function testGetBook()
    {
        $query = '{ 
            getBook (id: 4) {
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
            'getBook' => [
                'id' => 4,
                'title' => 'Herry Potter - E a pedra',
                'description' => 'Harry',
                'year' => '2024-06-01',
                'author_id' => 1,
                'category_id' => 1,
            ]
        ];

        $this->assertEquals($expected, $output['data']);
    }

    public function testSearchBook()
    {
        $query = '{ 
            searchBooks (search: "Herry Potter - E a pedra") {
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
            'searchBooks' => [
                [
                    'id' => 4,
                    'title' => 'Herry Potter - E a pedra',
                    'description' => 'Harry',
                    'year' => '2024-06-01',
                    'author_id' => 1,
                    'category_id' => 1,
                ],
            ]
        ];

        $this->assertEquals($expected, $output['data']);
    }
}
