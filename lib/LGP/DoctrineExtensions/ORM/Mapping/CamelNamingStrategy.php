<?php

namespace LGP\DoctrineExtensions\ORM\Mapping;

use Doctrine\ORM\Mapping\NamingStrategy;

/**
 * Camel naming strategy for Doctrine ORM
 * 
 * @author Roman Shamritskiy <roman@litgroup.ru>
 * @since  0.2.0
 * 
 * @see \Doctrine\ORM\Mapping\NamingStrategy::classToTableName()
 */
class CamelNamingStrategy implements NamingStrategy
{
    /**
     * {@inheritdoc}
     */
    public function classToTableName($className)
    {
        if (strpos($className, '\\') !== false) {
            return substr($className, strrpos($className, '\\') + 1);
        }

        return $className;

    }
    
    /**
     * {@inheritdoc}
     */
    public function propertyToColumnName($propertyName)
    {
        if (strpos($propertyName, '_') !== false) {
            
            $words = array_map(
                function($w) {
                    return ucfirst(strtolower($w));
                },
                explode('_', $propertyName)
            );
            
            $propertyName = lcfirst(implode($words));
        }
        
        return $propertyName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function referenceColumnName()
    {
        return 'id';

    }
    
    /**
     * {@inheritdoc}
     */
    public function joinColumnName($propertyName)
    {
        $propertyName = $this->propertyToColumnName($propertyName);
        
        return $propertyName.ucfirst($this->referenceColumnName());

    }
    
    /**
     * {@inheritdoc}
     */
    public function joinTableName($sourceEntity, $targetEntity, $propertyName = null)
    {
        return $this->classToTableName($sourceEntity) . '_has_' . $this->classToTableName($targetEntity);

    }
    
    /**
     * {@inheritdoc}
     */
    public function joinKeyColumnName($entityName, $referencedColumnName = null)
    {
        return lcfirst($this->classToTableName($entityName)) .
               ucfirst($referencedColumnName ? $referencedColumnName : $this->referenceColumnName());

    }

}
