<?php

namespace FDevs\MoscowOpenData\Model;

trait GenericPropertiesTrait
{
    /**
     * @var array
     */
    private $genericProperties = [];

    /**
     * @param array|GenericProperty[] $genericProperties
     * @return self
     */
    public function setGenericProperties(array $genericProperties)
    {
        $indexedProperties = [];
        foreach ($genericProperties as $property) {
            $indexedProperties[$property->getType()] = $property;
        }

        $this->genericProperties = $indexedProperties;

        return $this;
    }

    /**
     * @return array|GenericProperty[]
     */
    public function getGenericProperties()
    {
        return $this->genericProperties;
    }

    /**
     * @param string $type
     * @return GenericProperty
     * @throws \RuntimeException
     */
    public function getGenericProperty($type)
    {
        if (!isset($this->genericProperties[$type])) {
            throw new \RuntimeException(sprintf('Unknown property type: %s', $type));
        }

        return $this->genericProperties[$type];
    }

    /**
     * @param GenericProperty $property
     * @return self
     */
    public function setGenericProperty(GenericProperty $property)
    {
        $this->genericProperties[$property->getType()] = $property;

        return $this;
    }

    /**
     * @param string $type
     * @return bool
     */
    public function hasGenericProperty($type)
    {
        return isset($this->genericProperties[$type]);
    }
}
