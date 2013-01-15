<?php

namespace LGP\Tests\DoctrineExtensions\DBAL\Types;

use LGP\Tests\TestCase as LGPTestCase;

abstract class TestCase extends LGPTestCase
{
    
    /**
     * Platform Mock Object
     * @var \LGP\Tests\DoctrineExtensions\DBAL\Mocks\MockPlatform
     */
    protected static $platform;
    

    /**
     * @see \PHPUnit_Framework_TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass()
    {
        self::$platform = new \LGP\Tests\DoctrineExtensions\DBAL\Mocks\MockPlatform;
    }
    
    /**
     * @see \PHPUnit_Framework_TestCase::tearDownAfterClass()
     */
    public static function tearDownAfterClass()
    {
        self::$platform = null;
    }
}