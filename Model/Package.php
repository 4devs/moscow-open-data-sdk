<?php

namespace FDevs\MoscowOpenData\Model;

class Package
{
    /**
     * Total count if items of this type
     *
     * @var int|null
     */
    private $totalCount;

    /**
     * @var array
     */
    private $items;

    /**
     * @return int|null
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @param int $count
     * @return self
     */
    public function setTotalCount($count)
    {
        $this->totalCount = $count;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return self
     */
    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }
}
