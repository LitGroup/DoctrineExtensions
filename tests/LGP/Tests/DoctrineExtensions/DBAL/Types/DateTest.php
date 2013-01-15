<?php

namespace LGP\Tests\DoctrineExtensions\DBAL\Types;

use Doctrine\DBAL\Types\Type;

class DateTest extends TestCase
{
    /**
     * @var \Doctrine\DBAL\Types\Type
     */
    protected $type;

    /**
     * Time zone string
     * @var string
     */
    protected $tz;
    
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
        $this->defTypeClass  = $map[Type::DATE];
        
        Type::overrideType(Type::DATE, 'LGP\\DoctrineExtensions\\DBAL\\Types\\DateType');
        
        $this->type = Type::getType(Type::DATE);
        $this->tz   = \date_default_timezone_get();
    }

    public function tearDown()
    {
        Type::overrideType(Type::DATE, $this->defTypeClass);
        date_default_timezone_set($this->tz);
    }

    // ----------------------------------------------
    
    public function testCheckTypeName()
    {
        $this->assertSame('date', $this->type->getName());
    }
    
    public function testConvertsUtcToDatabaseValue()
    {
        $date   = new \DateTime('now', new \DateTimeZone('UTC'));
        $result = $this->type->convertToDatabaseValue(new \DateTime('now', new \DateTimeZone('UTC')), self::$platform);
        
        $this->assertTrue(is_string($result));
        $this->assertEquals(
            $date->format(self::$platform->getDateFormatString()),
            $result
        );
    }
    
    public function testConvertsNonUtcToDatabaseValue()
    {
        $date   = new \DateTime('now', new \DateTimeZone('UTC'));
        $result = $this->type->convertToDatabaseValue(new \DateTime('now', new \DateTimeZone('Europe/Moscow')), self::$platform);
        
        $this->assertTrue(is_string($result));
        $this->assertEquals(
                $date->format(self::$platform->getDateFormatString()),
                $result
        );
    }

    public function testConvertsToPHPValue()
    {
        $result = $this->type->convertToPHPValue('1988-08-29', self::$platform);
                
        $this->assertInstanceOf('\DateTime', $result);
        $this->assertEquals('1988-08-29', $result->format('Y-m-d'));
        $this->assertEquals('UTC', $result->getTimeZone()->getName());
    }
    
    public function testDateResetsNonDatePartsToZeroUnixTimeValues()
    {
        $date = $this->type->convertToPHPValue('1988-08-29', self::$platform);
    
        $this->assertEquals('00:00:00', $date->format('H:i:s'));
    }
    
    public function testDateRests_SummerTimeAffection()
    {
        date_default_timezone_set('Europe/Berlin');
    
        $date = $this->type->convertToPHPValue('2009-08-01', self::$platform);
        $this->assertEquals('00:00:00', $date->format('H:i:s'));
        $this->assertEquals('2009-08-01', $date->format('Y-m-d'));
    
        $date = $this->type->convertToPHPValue('2009-11-01', self::$platform);
        $this->assertEquals('00:00:00', $date->format('H:i:s'));
        $this->assertEquals('2009-11-01', $date->format('Y-m-d'));
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
        $date = new \DateTime('now', new \DateTimeZone('UTC'));
        
        $this->assertSame($date, $this->type->convertToPHPValue($date, self::$platform));
        $this->assertEquals('UTC', $date->getTimezone()->getName());
    }
    
    public function testConvertsNonUtcDateTimeToPHPValue()
    {
        $date = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
        
        $this->assertSame($date, $this->type->convertToPHPValue($date, self::$platform));
        $this->assertEquals('UTC', $date->getTimezone()->getName());
    }
}
