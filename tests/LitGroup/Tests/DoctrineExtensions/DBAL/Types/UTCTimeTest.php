<?php

namespace LitGroup\Tests\DoctrineExtensions\DBAL\Types;

use Doctrine\DBAL\Types\Type;

class UTCTimeTest extends TestCase
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
        Type::addType('utctime', 'LitGroup\\DoctrineExtensions\\DBAL\\Types\\UTCTimeType');
        
        $this->type = Type::getType('utctime');
    }

    // ----------------------------------------------
    
    public function testCheckTypeName()
    {
        $this->assertSame('utctime', $this->type->getName());
    }
}
