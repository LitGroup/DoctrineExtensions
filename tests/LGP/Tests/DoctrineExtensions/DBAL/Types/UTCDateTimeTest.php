<?php

namespace LGP\Tests\DoctrineExtensions\DBAL\Types;

use Doctrine\DBAL\Types\Type;

class UTCDateTimeTest extends TestCase
{
    /**
     * @var \Doctrine\DBAL\Types\Type
     */
    protected $type;

    
    /**
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        Type::addType('utcdatetime', 'LGP\\DoctrineExtensions\\DBAL\\Types\\UTCDateTimeType');
        
        $this->type = Type::getType('utcdatetime');
    }

    // ----------------------------------------------
    
    public function testCheckTypeName()
    {
        $this->assertSame('utcdatetime', $this->type->getName());
    }
}
