<?php

namespace FDevs\MoscowOpenData\Model;

class DataTypeEntry
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $number;

    /**
     * @var array
     */
    private $genericProperties = [];

    /**
     * @param array $genericProperties
     * @return self
     */
    public function setGenericProperties($genericProperties)
    {
        $this->genericProperties = $genericProperties;

        return $this;
    }

    /**
     * @return array
     */
    public function getGenericProperties()
    {
        return $this->genericProperties;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $number
     * @return self
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }
}
