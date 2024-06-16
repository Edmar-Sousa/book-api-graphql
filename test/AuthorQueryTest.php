<?php declare(strict_types=1);

namespace Test;

require_once __DIR__ . '/../vendor/autoload.php';


use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use PHPUnit\Framework\TestCase;
use Src\Schema\Query\AuthorQuery;



class AuthorQueryTest extends TestCase
{

    protected Schema $authorSchema;


    protected function setUp(): void
    {

        $this->authorSchema = new Schema(
            (new SchemaConfig())->setQuery(new AuthorQuery())
        );

    }



    public function testListAuthors()
    {
        $query = '{ 
            listAuthors {
                id
                name
                bio
            }
        }';


        $result = GraphQL::executeQuery($this->authorSchema, $query);
        $output = $result->toArray();

        $expected = [
            'listAuthors' => [
                [
                    'id' => 1,
                    'name' => 'Edinho',
                    'bio' => 'Um otimo escritor',
                ]
            ]
        ];

        return $this->assertEquals($expected, $output['data']);
    }



    public function testGetAuthorWithId()
    {
        $query = '{
            getAuthor (id: 1) {
                id
                name
                bio
            }
        }';


        $result = GraphQL::executeQuery($this->authorSchema, $query);
        $output = $result->toArray();

        $expected = [
            'getAuthor' => [
                'id' => 1,
                'name' => 'Edinho',
                'bio' => 'Um otimo escritor',
            ]
        ];

        return $this->assertEquals($expected, $output['data']);
    }


    public function testSearchAuthor()
    {
        $query = '{
            searchAuthors (search: "Edinho") {
                id
                name
                bio
            }
        }';


        $result = GraphQL::executeQuery($this->authorSchema, $query);
        $output = $result->toArray();

        $expected = [
            'searchAuthors' => [
                [
                    'id' => 1,
                    'name' => 'Edinho',
                    'bio' => 'Um otimo escritor',
                ]
            ]
        ];

        return $this->assertEquals($expected, $output['data']);
    }
}
