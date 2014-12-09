<?php

namespace FDevs\MoscowOpenData\Model;

class GenericProperty
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $caption;

    /**
     * @var bool
     */
    private $visible = true;

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
     * @param string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param boolean $visible
     * @return self
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }
}
