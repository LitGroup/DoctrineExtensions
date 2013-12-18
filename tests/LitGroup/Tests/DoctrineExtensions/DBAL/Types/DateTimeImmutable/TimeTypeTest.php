<?php
/**
 * This file is part of the "LitGroupDoctrineExtensions" project.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Tests\DoctrineExtensions\DBAL\Types\DateTimeImmutable;

use LitGroup\Tests\DoctrineExtensions\DBAL\Types\TimeTypeTest as BaseTest;


class TimeTypeTest extends BaseTest
{
    /**
     * @param string        $time
     * @param \DateTimeZone $tz
     *
     * @return \DateTimeImmutable
     */
    protected function createDateTime($time = 'now', \DateTimeZone $tz)
    {
        return new \DateTimeImmutable($time, $tz);
    }

}