<?php

namespace FDevs\MoscowOpenData\Model;

class QueryFilter
{
    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $skip;

    /**
     * Provide a total records count with response or not
     *
     * @var bool
     */
    private $showInlineCount = false;

    /**
     * @var string
     */
    private $orderBy;

    /**
     * @param int $limit
     * @return self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param string $orderBy
     * @return self
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param boolean $showInlineCount
     * @return self
     */
    public function setShowInlineCount($showInlineCount)
    {
        $this->showInlineCount = (bool) $showInlineCount;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getShowInlineCount()
    {
        return $this->showInlineCount;
    }

    /**
     * @param int $skip
     * @return self
     */
    public function setSkip($skip)
    {
        $this->skip = $skip;

        return $this;
    }

    /**
     * @return int
     */
    public function getSkip()
    {
        return $this->skip;
    }
}
