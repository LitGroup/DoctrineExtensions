<?php

namespace LGP\Tests\DoctrineExtensions\DBAL\Types;

use Doctrine\DBAL\Types\Type;

class UTCDateTest extends TestCase
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
        Type::addType('utcdate', 'LGP\\DoctrineExtensions\\DBAL\\Types\\UTCDateType');
        
        $this->type = Type::getType('utcdate');
    }

    // ----------------------------------------------
    
    public function testCheckTypeName()
    {
        $this->assertSame('utcdate', $this->type->getName());
    }
}
