<?php declare(strict_types=1);

namespace Src\Database;

use Exception;
use PDO;
use RuntimeException;



$sqlInitScript = __DIR__ . '/init.sql';

if (!is_readable($sqlInitScript))
    throw new RuntimeException('The "init.sql" file is not readable or not exists.');



$sql = file_get_contents($sqlInitScript);
$connection = new PDO('mysql:host=localhost;dbname=graphql', 'root', 'adminroot');

$result = $connection->query($sql);

if ($result === false)
    throw new RuntimeException('Erro ao execultar sql: ' . print_r($connection->errorInfo(), true));


echo "Database created with success!" . PHP_EOL;

