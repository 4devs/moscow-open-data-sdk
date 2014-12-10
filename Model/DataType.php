<?php

namespace FDevs\MoscowOpenData\Model;

class DataType
{
    use GenericPropertiesTrait;

    /**
     * Unique identifier
     *
     * @var int
     */
    private $id;

    /**
     * Theme category id
     *
     * @var int
     */
    private $categoryId;

    /**
     * @var string
     */
    private $categoryCaption;

    /**
     * Responsible for data department identifier
     *
     * @var int
     */
    private $departmentId;

    /**
     * @var string
     */
    private $departmentCaption;

    /**
     * Title of data type
     *
     * @var string
     */
    private $caption;

    /**
     * @var string
     */
    private $description;

    /**
     * @var bool
     */
    private $hasGeodata;

    /**
     * @param string $caption
     * @return self
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param int $categoryId
     * @return self
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $departmentId
     * @return self
     */
    public function setDepartmentId($departmentId)
    {
        $this->departmentId = $departmentId;

        return $this;
    }

    /**
     * @return int
     */
    public function getDepartmentId()
    {
        return $this->departmentId;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $categoryCaption
     * @return self
     */
    public function setCategoryCaption($categoryCaption)
    {
        $this->categoryCaption = $categoryCaption;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategoryCaption()
    {
        return $this->categoryCaption;
    }

    /**
     * @param string $departmentCaption
     * @return self
     */
    public function setDepartmentCaption($departmentCaption)
    {
        $this->departmentCaption = $departmentCaption;

        return $this;
    }

    /**
     * @return string
     */
    public function getDepartmentCaption()
    {
        return $this->departmentCaption;
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param boolean $hasGeodata
     * @return self
     */
    public function setHasGeodata($hasGeodata)
    {
        $this->hasGeodata = (bool) $hasGeodata;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getHasGeodata()
    {
        return $this->hasGeodata;
    }
}
