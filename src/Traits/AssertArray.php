<?php declare(strict_types=1);


namespace Src\Traits;

use PHPUnit\Framework\TestCase;


require_once __DIR__ . '/../../vendor/autoload.php';



trait AssertArray
{
    public function assertArrayContains(array $needed, array $list, TestCase $testIntance)
    {

        $finded = false;

        foreach ($list as $amount) {
            if (empty(array_diff($amount, $needed)))
                $finded = true;
        }


        $testIntance->assertTrue($finded);

    }
}

