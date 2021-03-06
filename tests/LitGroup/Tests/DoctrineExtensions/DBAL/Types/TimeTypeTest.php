<?php

namespace LitGroup\Tests\DoctrineExtensions\DBAL\Types;

use Doctrine\DBAL\Types\Type;

class TimeTypeTest extends TestCase
{
    /**
     * @var \Doctrine\DBAL\Types\Type
     */
    protected $type;

    /**
     * Default type class
     * 
     * @var string
     */
    protected $defTypeClass;
    
    /**
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $map = Type::getTypesMap();
        $this->defTypeClass  = $map[Type::TIME];
        
        Type::overrideType(Type::TIME, 'LitGroup\\DoctrineExtensions\\DBAL\\Types\\TimeType');
        
        $this->type = Type::getType(Type::TIME);
    }

    public function tearDown()
    {
        Type::overrideType(Type::TIME, $this->defTypeClass);
    }

    // ----------------------------------------------
    
    public function testCheckTypeName()
    {
        $this->assertSame('time', $this->type->getName());
    }
    
    public function testConvertsUtcToDatabaseValue()
    {
        $date   = $this->createDateTime('now', new \DateTimeZone('UTC'));
        $result = $this->type->convertToDatabaseValue($this->createDateTime('now', new \DateTimeZone('UTC')), self::$platform);
        
        $this->assertTrue(is_string($result));
        $this->assertEquals(
            $date->format(self::$platform->getTimeFormatString()),
            $result
        );
    }
    
    public function testConvertsNonUtcToDatabaseValue()
    {
        $date   = $this->createDateTime('now', new \DateTimeZone('UTC'));
        $result = $this->type->convertToDatabaseValue($this->createDateTime('now', new \DateTimeZone('Europe/Moscow')), self::$platform);
        
        $this->assertTrue(is_string($result));
        $this->assertEquals(
                $date->format(self::$platform->getTimeFormatString()),
                $result
        );
    }

    public function testConvertsToPHPValue()
    {
        $result = $this->type->convertToPHPValue('01:55:43', self::$platform);
                
        $this->assertInstanceOf('\DateTime', $result);
        $this->assertEquals('01:55:43', $result->format('H:i:s'));
        $this->assertEquals('UTC', $result->getTimeZone()->getName());
    }
    
    public function testInvalidDateFormatConversion()
    {
        $this->setExpectedException('Doctrine\DBAL\Types\ConversionException');
        $this->type->convertToPHPValue('abcdefg', self::$platform);
    }

    public function testNullConversion()
    {
        $this->assertNull($this->type->convertToPHPValue(null, self::$platform),
                'Conversion null to PHP failed');
        $this->assertNull($this->type->convertToDatabaseValue(null, self::$platform),
                'Conversion null to database failed');
    }

    public function testConvertsUtcDateTimeToPHPValue()
    {
        $date = $this->createDateTime('now', new \DateTimeZone('UTC'));
        
        $this->assertSame($date, $this->type->convertToPHPValue($date, self::$platform));
        $this->assertEquals('UTC', $date->getTimezone()->getName());
    }
    
    public function testConvertsNonUtcDateTimeToPHPValue()
    {
        $date = $this->createDateTime('now', new \DateTimeZone('Europe/Moscow'));

        $converted = $this->type->convertToPHPValue($date, self::$platform);
        $date = $date->setTimezone(new \DateTimeZone('UTC'));
        $this->assertEquals($date->format('H:i:s'), $converted->format('H:i:s'));
        $this->assertEquals('UTC', $date->getTimezone()->getName());
    }

}
