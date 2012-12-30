<?php

namespace LitGroup\DoctrineExtensions\DBAL\Types;

use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Type that maps an SQL DATETIME/TIMESTAMP to a PHP DateTime object.
 * 
 * This class may to be used as `utcdatetime` type.
 * It always saves datetime in UTC and retrieves in UTC too.
 * 
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class UTCDateTimeType extends DateTimeType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'utcdatetime';
    }
}