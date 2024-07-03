<?php declare(strict_types=1);



use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;

use Src\Schema\Query\AuthorQuery;
use Src\Schema\Query\BookQuery;
use Src\Schema\Query\CategoryQuery;

use Src\Schema\Multation\AuthorMultation;
use Src\Schema\Multation\BookMultation;
use Src\Schema\Multation\CategoryMultation;

require_once __DIR__ . '/../vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    exit(0);
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');



$queryFields = array_merge(
    (new AuthorQuery())->config['fields'],
    (new BookQuery())->config['fields'],
    (new CategoryQuery())->config['fields']
);

$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => $queryFields,
]);


$mutationFields = array_merge(
    (new BookMultation())->config['fields'],
    (new AuthorMultation())->config['fields'],
    (new CategoryMultation())->config['fields'],
);

$mutationType = new ObjectType([
    'name' => 'Mutation',
    'fields' => $mutationFields,
]);


try {

    $schema = new Schema(
        ((new SchemaConfig())
            ->setQuery($queryType)
            ->setMutation($mutationType))
    );


    $rawInput = file_get_contents('php://input');
    if ($rawInput === false)
        throw new RuntimeException('Failed to get php://input');


    $input = json_decode($rawInput, true);
    $query = $input['query'];
    $variableValues = $input['variables'] ?? null;


    $result = GraphQL::executeQuery($schema, $query, null, null, $variableValues);
    $output = $result->toArray();

} catch (Exception $err) {
    $output = [
        'error' => [
            'message' => $e->getMessage(),
        ],
    ];
}


header('Content-Type: application/json; charset=UTF-8');
echo json_encode($output, JSON_THROW_ON_ERROR);
