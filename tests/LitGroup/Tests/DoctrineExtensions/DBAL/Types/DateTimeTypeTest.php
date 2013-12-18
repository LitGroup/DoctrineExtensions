<?php

namespace LitGroup\Tests\DoctrineExtensions\DBAL\Types;

use Doctrine\DBAL\Types\Type;

class DateTimeTypeTest extends TestCase
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
        $this->defTypeClass  = $map[Type::DATETIME];
        
        Type::overrideType(Type::DATETIME, 'LitGroup\\DoctrineExtensions\\DBAL\\Types\\DateTimeType');
        
        $this->type = Type::getType(Type::DATETIME);
    }

    public function tearDown()
    {
        Type::overrideType(Type::DATETIME, $this->defTypeClass);
    }

    // ----------------------------------------------
    
    public function testCheckTypeName()
    {
        $this->assertSame('datetime', $this->type->getName());
    }
    
    public function testConvertsUtcToDatabaseValue()
    {
        $date   = $this->createDateTime('now', new \DateTimeZone('UTC'));
        $result = $this->type->convertToDatabaseValue($this->createDateTime('now', new \DateTimeZone('UTC')), self::$platform);
        
        $this->assertTrue(is_string($result));
        $this->assertEquals(
            $date->format(self::$platform->getDateTimeFormatString()),
            $result
        );
    }
    
    public function testConvertsNonUtcToDatabaseValue()
    {
        $date   = $this->createDateTime('now', new \DateTimeZone('UTC'));
        $result = $this->type->convertToDatabaseValue($this->createDateTime('now', new \DateTimeZone('Europe/Moscow')), self::$platform);
        
        $this->assertTrue(is_string($result));
        $this->assertEquals(
                $date->format(self::$platform->getDateTimeFormatString()),
                $result
        );
    }

    public function testConvertsToPHPValue()
    {
        $result = $this->type->convertToPHPValue('1988-08-29 12:00:00', self::$platform);
                
        $this->assertInstanceOf('\DateTime', $result);
        $this->assertEquals('1988-08-29 12:00:00', $result->format('Y-m-d H:i:s'));
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
        $this->assertEquals($date->format('U'), $converted->format('U'));
        $this->assertEquals('UTC', $converted->getTimezone()->getName());
    }
}
