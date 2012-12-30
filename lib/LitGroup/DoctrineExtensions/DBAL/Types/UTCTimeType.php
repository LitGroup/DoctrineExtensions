<?php

namespace LitGroup\DoctrineExtensions\DBAL\Types;

use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Type that maps an SQL TIME/TIMESTAMP to a PHP DateTime object.
 * 
 * This class may to be used as `utctime` type.
 * It always saves time in UTC and retrieves in UTC too.
 * 
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class UTCTimeType extends TimeType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'utctime';
    }
}