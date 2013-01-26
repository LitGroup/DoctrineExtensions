<?php

namespace LitGroup\Tests\DoctrineExtensions\DBAL\Types;

use Doctrine\DBAL\Types\Type;

class UTCDateTimeTypeTest extends TestCase
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
        Type::addType('utcdatetime', 'LitGroup\\DoctrineExtensions\\DBAL\\Types\\UTCDateTimeType');
        
        $this->type = Type::getType('utcdatetime');
    }

    // ----------------------------------------------
    
    public function testCheckTypeName()
    {
        $this->assertSame('utcdatetime', $this->type->getName());
    }
}
