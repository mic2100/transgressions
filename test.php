<?php

require_once __DIR__ . '/vendor/autoload.php';

use Transgressions\Agitator;
use Transgressions\Metadata\Exception as MetadataException;
use Transgressions\Metadata\Query as QueryMetadata;
use TransgressionsTest\Utility\NestedException;
use Throwable;

function testException()
{
    try {
        echo 'Testing Whoops Inspector' . PHP_EOL;

        (new NestedException)->test();
    } catch (Throwable $exception) {
        $mdException = new MetadataException($exception);
        $processDigest = Agitator::getInstance();
        $processDigest->setException($mdException);
        $processDigest->addMetadata(new QueryMetadata(
            'SELECT * FROM table WHERE id > ? AND id < ?',
            [10, 100],
            12.43
        ));

        echo json_encode($processDigest->toArray(), JSON_PRETTY_PRINT);
    }
}

testException();
