<?php declare(strict_types=1);

namespace Src\Test;

require_once __DIR__ . '/../../vendor/autoload.php';


use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;


use Src\Schema\Multation\CategoryMultation;
use Src\Schema\Query\CategoryQuery;

use Src\Traits\AssertArray;

class CategoryTest extends TestCase
{
    use AssertArray;

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

        return $output['data']['addCategory']['id'];
    }


    #[Depends('testAddCategory')]
    public function testListCategory($categoryId)
    {
        $query = '{ 
            listCategory {
                id
                title
            }
        }';


        $result = GraphQL::executeQuery($this->categorySchema, $query);
        $output = $result->toArray();

        $this->assertArrayHasKey('listCategory', $output['data']);


        $categorys = $output['data']['listCategory'];

        $expected = [
            'id' => $categoryId,
            'title' => 'mock category',
        ];


        $this->assertArrayContains($expected, $categorys, $this);
    }



    #[Depends('testAddCategory')]
    public function testGetCategory($categoryId)
    {
        $query = "{ 
            getCategory (id: $categoryId) {
                id
                title
            }
        }";


        $result = GraphQL::executeQuery($this->categorySchema, $query);
        $output = $result->toArray();

        $expected = [
            'getCategory' => [
                'id' => $categoryId,
                'title' => 'mock category',
            ]
        ];

        $this->assertEquals($expected, $output['data']);
    }


    #[Depends('testAddCategory')]
    public function testSearchCategory($categoryId)
    {
        $query = '{ 
            searchCategory (search: "mock category") {
                id
                title
            }
        }';


        $result = GraphQL::executeQuery($this->categorySchema, $query);
        $output = $result->toArray();

        $categorys = $output['data']['searchCategory'];

        $expected = [
            'id' => $categoryId,
            'title' => 'mock category',
        ];


        $this->assertArrayContains($expected, $categorys, $this);
    }


    #[Depends('testAddCategory')]
    public function testUpdateCategory($categoryId)
    {
        $query = "mutation {
            updateCategory(title: \"Update Category\", id: $categoryId) {
                id
                title
            }
        }";


        $result = GraphQL::executeQuery($this->categorySchema, $query);
        $output = $result->toArray();


        $expected = [
            'updateCategory' => [
                'id' => $categoryId,
                'title' => 'Update Category',
            ]
        ];


        $this->assertEquals($expected, $output['data']);

        return $categoryId;
    }


    #[Depends('testUpdateCategory')]
    public function testDeleteCategory($categoryId)
    {
        $query = "mutation {
            deleteCategory(id: $categoryId) {
                id
                title
            }
        }";

        $result = GraphQL::executeQuery($this->categorySchema, $query);
        $output = $result->toArray();


        $expected = [
            'deleteCategory' => [
                'id' => $categoryId,
                'title' => 'Update Category',
            ]
        ];


        $this->assertEquals($expected, $output['data']);
    }
}
