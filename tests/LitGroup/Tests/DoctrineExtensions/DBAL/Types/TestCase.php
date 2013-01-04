<?php

namespace LitGroup\Tests\DoctrineExtensions\DBAL\Types;

use LitGroup\Tests\TestCase as LitGroupTestCase;

abstract class TestCase extends LitGroupTestCase
{
    
    /**
     * Platform Mock Object
     * @var \LitGroup\Tests\DoctrineExtensions\DBAL\Mocks\MockPlatform
     */
    protected static $platform;
    

    /**
     * @see \PHPUnit_Framework_TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass()
    {
        self::$platform = new \LitGroup\Tests\DoctrineExtensions\DBAL\Mocks\MockPlatform;
    }
    
    /**
     * @see \PHPUnit_Framework_TestCase::tearDownAfterClass()
     */
    public static function tearDownAfterClass()
    {
        self::$platform = null;
    }
}