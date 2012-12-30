<?php

namespace LitGroup\DoctrineExtensions\DBAL\Types;

use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Type that maps an SQL DATE/TIMESTAMP to a PHP DateTime object.
 * 
 * This class may to be used as `utcdate` type.
 * It always saves date in UTC and retrieves in UTC too.
 * 
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class UTCDateType extends DateType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'utcdate';
    }
}