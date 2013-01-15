<?php

namespace LGP\DoctrineExtensions\DBAL\Types;

use Doctrine\DBAL\Types\DateType as Type;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Type that maps an SQL DATE/TIMESTAMP to a PHP DateTime object.
 * 
 * This class must be used to override built-in Doctrine type.
 * It always saves date in UTC and retrieves in UTC too.
 * 
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class DateType extends Type
{
    /**
     * @var \DateTimeZone
     */
    static private $utc = null;
    
    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        
        $value->setTimezone($this->getUtcTz());
    
        return $value->format($platform->getDateFormatString());
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        
        if ($value instanceof \DateTime) {
            $value->setTimezone($this->getUtcTz());
            
            return $value;
        }
        
        $val = \DateTime::createFromFormat(
                    '!'.$platform->getDateFormatString(),
                    $value,
                    $this->getUtcTz()
                )
        ;
        
        if (!$val) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }
        
        return $val;
    }
    
    /**
     * Get UTC DateTimeZone
     * 
     * @return \DateTimeZone
     */
    protected function getUtcTz()
    {
        if (self::$utc === null) {
            self::$utc = new \DateTimeZone('UTC');
        }
        
        return self::$utc;
    }
}