<?php

namespace LitGroup\Tests\DoctrineExtensions\ORM\Mapping;

use LitGroup\Tests\TestCase;
use LitGroup\DoctrineExtensions\ORM\Mapping\CamelNamingStrategy;

class CamelNamingStrategyTest extends TestCase
{
    /**
     * @var \Doctrine\ORM\Mapping\NamingStrategy
     */
    protected $strategy;

    /**
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->strategy = new CamelNamingStrategy;
    }
    
    // ----------------------------------------------
    
    /**
     * Data Provider for NamingStrategy#classToTableName
     *
     * @return array
     */
    static public function dataClassToTableName()
    {
        return array(
                array('SomeClassName', 'SomeClassName'),
                array('SomeClassName', '\SomeClassName'),
                array('Name',          '\Some\Class\Name'),
        );
    }
    
    /**
     * @dataProvider dataClassToTableName
     * 
     * @param string $expected
     * @param string $className
     */
    public function testClassToTableName($expected, $className)
    {
        $this->assertEquals($expected, $this->strategy->classToTableName($className));
    }
    
    /**
     * Data Provider for NamingStrategy#propertyToColumnName
     *
     * @return array
     */
    static public function dataPropertyToColumnName()
    {
        return array(
                array('someProperty', 'someProperty'),
                array('someProperty', 'SOME_PROPERTY'),
                array('someProperty', 'some_property'),
        );
    }
    
    /**
     * @dataProvider dataPropertyToColumnName
     *
     * @param string $expected
     * @param string $propertyName
     */
    public function testPropertyToColumnName($expected, $propertyName)
    {
        $this->assertEquals($expected, $this->strategy->propertyToColumnName($propertyName));
    }
    
    /**
     * Data Provider for NamingStrategy#referenceColumnName
     *
     * @return array
     */
    static public function dataReferenceColumnName()
    {
        return array(
                array('id'),
        );
    }
    
    /**
     * @dataProvider dataReferenceColumnName
     *
     * @param string $expected
     */
    public function testReferenceColumnName($expected)
    {
        $this->assertEquals($expected, $this->strategy->referenceColumnName());
    }
    
    /**
     * Data Provider for NamingStrategy#joinColumnName
     *
     * @return array
     */
    static public function dataJoinColumnName()
    {
        return array(
                array('someColumnId', 'someColumn'),
                array('someColumnId', 'some_column'),
        );
    }
    
    /**
     * @dataProvider dataJoinColumnName
     *
     * @param string $expected
     * @param string $propertyName
     */
    public function testJoinColumnName($expected, $propertyName)
    {
        $this->assertEquals($expected, $this->strategy->joinColumnName($propertyName));
    }
    
    /**
     * Data Provider for NamingStrategy#joinTableName
     *
     * @return array
     */
    static public function dataJoinTableName()
    {
        return array(
                array('SomeClassName_has_ClassName', 'SomeClassName', 'Some\ClassName', null),
                array('SomeClassName_has_ClassName', '\SomeClassName', 'ClassName', null),
                array('Name_has_ClassName', '\Some\Class\Name', 'ClassName', null),
        );
    }
    
    /**
     * @dataProvider dataJoinTableName
     *
     * @param string $expected
     * @param string $ownerEntity
     * @param string $associatedEntity
     * @param string $propertyName
     */
    public function testJoinTableName($expected, $ownerEntity, $associatedEntity, $propertyName = null)
    {
        $this->assertEquals($expected, $this->strategy->joinTableName($ownerEntity, $associatedEntity, $propertyName));
    }
    
    /**
     * Data Provider for NamingStrategy#joinKeyColumnName
     *
     * @return array
     */
    static public function dataJoinKeyColumnName()
    {
        return array(
                array('someClassNameId', 'SomeClassName', null, null),
                array('nameIdentifier', '\Some\Class\Name', 'identifier', null),
        );
    }
    
    /**
     * @dataProvider dataJoinKeyColumnName
     *
     * @param string $expected
     * @param string $propertyEntityName
     * @param string $referencedColumnName
     * @param string $propertyName
     */
    public function testJoinKeyColumnName($expected, $propertyEntityName, $referencedColumnName = null, $propertyName = null)
    {
        $this->assertEquals($expected, $this->strategy->joinKeyColumnName($propertyEntityName, $referencedColumnName, $propertyName));
    }

}
