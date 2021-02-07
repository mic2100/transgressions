<?php

use Transgressions\Metadata\Query;
use Transgressions\TestNestedException;

require_once __DIR__ . '/vendor/autoload.php';

function testException()
{
    try {
        echo 'Testing Whoops Inspector' . PHP_EOL;

        (new TestNestedException)->test();
    } catch (\Throwable $exception) {
        $mdException = new \Transgressions\Metadata\Exception($exception);
        $processDigest = \Transgressions\Agitator::getInstance();
        $processDigest->setException($mdException);
        $processDigest->addMetadata(new Query(
            'test query',
            ['value-1', 'value_2'],
            12.43
        ));

        echo json_encode($processDigest->toArray(), JSON_PRETTY_PRINT);
    }
}

testException();


