<?php declare(strict_types=1);

namespace Src\Test;

require_once __DIR__ . '/../../vendor/autoload.php';


use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

use Src\Schema\Multation\AuthorMultation;
use Src\Schema\Query\AuthorQuery;

use Src\Traits\AssertArray;



class AuthorQueryTest extends TestCase
{

    use AssertArray;

    protected Schema $authorSchema;


    protected function setUp(): void
    {

        $this->authorSchema = new Schema(
            (new SchemaConfig())
                ->setQuery(new AuthorQuery())
                ->setMutation(new AuthorMultation())
        );

    }



    public function testAddAuthor()
    {
        $query = '
            mutation {
                addAuthor(name: "Author Mock", bio: "Testando insert author") {
                    id
                    name
                    bio
                }
            }
        ';

        $result = GraphQL::executeQuery($this->authorSchema, $query);
        $output = $result->toArray();

        $this->assertNotEmpty($output['data'], 'The "data" is empty');

        $mockAuthor = [
            'addAuthor' => [
                'id' => $output['data']['addAuthor']['id'],
                'name' => 'Author Mock',
                'bio' => 'Testando insert author',
            ],
        ];

        $this->assertEquals($mockAuthor, $output['data']);


        return $output['data']['addAuthor']['id'];
    }


    #[Depends('testAddAuthor')]
    public function testListAuthors(int $authorId)
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

        $this->assertArrayHasKey('listAuthors', $output['data']);

        $authors = $output['data']['listAuthors'];

        $expected = [
            'id' => $authorId,
            'name' => 'Author Mock',
            'bio' => 'Testando insert author',
        ];



        $this->assertArrayContains($expected, $authors, $this);

    }



    #[Depends('testAddAuthor')]
    public function testGetAuthorWithId(int $authorId)
    {
        $query = "{
            getAuthor (id: $authorId) {
                id
                name
                bio
            }
        }";


        $result = GraphQL::executeQuery($this->authorSchema, $query);
        $output = $result->toArray();

        $expected = [
            'getAuthor' => [
                'id' => $authorId,
                'name' => 'Author Mock',
                'bio' => 'Testando insert author',
            ]
        ];

        return $this->assertEquals($expected, $output['data']);
    }


    #[Depends('testAddAuthor')]
    public function testSearchAuthor(int $authorId)
    {
        $query = '{
            searchAuthors (search: "Author Mock") {
                id
                name
                bio
            }
        }';


        $result = GraphQL::executeQuery($this->authorSchema, $query);
        $output = $result->toArray();

        $this->assertArrayHasKey('searchAuthors', $output['data']);

        $authors = $output['data']['searchAuthors'];

        $expected = [
            'id' => $authorId,
            'name' => 'Author Mock',
            'bio' => 'Testando insert author',
        ];

        $this->assertArrayContains($expected, $authors, $this);

    }



    #[Depends('testAddAuthor')]
    public function testUpdateAuthor(int $authorId)
    {
        $query = "mutation {
            updateAuthor (id: $authorId, name: \"Author Updated\", bio: \"Bio updated author\") {
                id
                name
                bio
            }
        }";

        $result = GraphQL::executeQuery($this->authorSchema, $query);
        $output = $result->toArray();


        $this->assertNotEmpty($output['data'], 'The "data" is empty');


        $mockAuthor = [
            'updateAuthor' => [
                'id' => $output['data']['updateAuthor']['id'],
                'name' => 'Author Updated',
                'bio' => 'Bio updated author',
            ],
        ];

        $this->assertEquals($mockAuthor, $output['data']);


        return $output['data']['updateAuthor']['id'];
    }


    #[Depends('testUpdateAuthor')]
    public function testDeleteAuthor($authorId)
    {
        $query = "mutation {
            deleteAuthor (id: $authorId) {
                id
                name
                bio
            }
        }";

        $result = GraphQL::executeQuery($this->authorSchema, $query);
        $output = $result->toArray();


        $this->assertNotEmpty($output['data'], 'The "data" is empty');


        $mockAuthor = [
            'deleteAuthor' => [
                'id' => $authorId,
                'name' => 'Author Updated',
                'bio' => 'Bio updated author',
            ],
        ];

        $this->assertEquals($mockAuthor, $output['data']);
    }
}
