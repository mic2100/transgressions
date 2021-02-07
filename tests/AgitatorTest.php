<?php

declare(strict_types=1);

namespace Mic2100Test;

use Exception;
use Transgressions\Metadata\Exception as MetadataException;
use Transgressions\Metadata\Query;
use Transgressions\Agitator;
use PHPUnit\Framework\TestCase;

class AgitatorTest extends TestCase
{
    /**
     * @covers Agitator::__construct
     */
    public function testSingletonExpectsDuplicateInstance()
    {
        $processDigest1 = Agitator::getInstance();
        $processDigest2 = Agitator::getInstance();
        $exception = new Exception('Testing');
        $mdException = new MetadataException($exception);
        $processDigest1->setException($mdException);
        $processDigest1->addMetadata(new Query(
            'test query',
            ['value-1', 'value_2'],
            12.43
        ));

        $this->assertSame($processDigest1?->getException(), $processDigest2->getException());
        $this->assertSame($processDigest1->getMetadata(), $processDigest2->getMetadata());
    }

    /**
     * @covers Agitator::__construct
     */
    public function testInstantiateClassManuallyExpectsFailure()
    {
        $this->expectException('Error');
        new Agitator();
    }
}
