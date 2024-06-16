<?php declare(strict_types=1);

namespace Test;

require_once __DIR__ . '/../vendor/autoload.php';


use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use PHPUnit\Framework\TestCase;


use Src\Schema\Query\BookQuery;


class BookQueryTest extends TestCase
{

    protected Schema $bookSchema;


    protected function setUp(): void
    {

        $this->bookSchema = new Schema(
            (new SchemaConfig())->setQuery(new BookQuery())
        );

    }



    public function testListBooks()
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
                [
                    'id' => 4,
                    'title' => 'Herry Potter - E a pedra',
                    'description' => 'Harry',
                    'year' => '2024-06-01',
                    'author_id' => 1,
                    'category_id' => 1,
                ]
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
