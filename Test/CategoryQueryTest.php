<?php declare(strict_types=1);

namespace Test;

require_once __DIR__ . '/../vendor/autoload.php';


use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use PHPUnit\Framework\TestCase;


use Src\Schema\Multation\CategoryMultation;
use Src\Schema\Query\CategoryQuery;


class CategoryQueryTest extends TestCase
{

    protected Schema $categorySchema;


    protected function setUp(): void
    {

        $this->categorySchema = new Schema(
            (new SchemaConfig())
                ->setQuery(new CategoryQuery())
                ->setMutation(new CategoryMultation())
        );

    }


    public function testAddCategory()
    {
        $query = 'mutation {
            addCategory (title: "mock category") {
                id
                title
            }
        }';

        $result = GraphQL::executeQuery($this->categorySchema, $query);
        $output = $result->toArray();

        $expected = [
            'addCategory' => [
                'id' => $output['data']['addCategory']['id'],
                'title' => 'mock category',
            ]
        ];

        $this->assertEquals($expected, $output['data']);
    }


    public function testListCategory()
    {
        $query = '{ 
            listCategory {
                id
                title
            }
        }';


        $result = GraphQL::executeQuery($this->categorySchema, $query);
        $output = $result->toArray();

        $expected = [
            'listCategory' => [
                [
                    'id' => 1,
                    'title' => 'Literatura Juvenil',
                ]
            ]
        ];

        $this->assertEquals($expected, $output['data']);
    }



    public function testGetCategory()
    {
        $query = '{ 
            getCategory (id: 1) {
                id
                title
            }
        }';


        $result = GraphQL::executeQuery($this->categorySchema, $query);
        $output = $result->toArray();

        $expected = [
            'getCategory' => [
                'id' => 1,
                'title' => 'Literatura Juvenil',
            ]
        ];

        $this->assertEquals($expected, $output['data']);
    }


    public function testSearchCategory()
    {
        $query = '{ 
            searchCategory (search: "Literatura") {
                id
                title
            }
        }';


        $result = GraphQL::executeQuery($this->categorySchema, $query);
        $output = $result->toArray();

        $expected = [
            'searchCategory' => [
                [
                    'id' => 1,
                    'title' => 'Literatura Juvenil',
                ]
            ]
        ];

        $this->assertEquals($expected, $output['data']);
    }
}
