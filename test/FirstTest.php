<?php declare(strict_types=1);

namespace Test;

require_once __DIR__ . '/../vendor/autoload.php';


use PHPUnit\Framework\TestCase;
use Src\Models\First;



class FirstTest extends TestCase
{
    public function testHelloTest()
    {
        $first = new First();

        $msg = $first->helloTest();

        return $this->assertSame('Hello Test!', $msg);
    }
}

