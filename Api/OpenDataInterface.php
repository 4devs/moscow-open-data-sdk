<?php

namespace FDevs\MoscowOpenData\Api;

use FDevs\MoscowOpenData\Model\DataType;
use FDevs\MoscowOpenData\Model\DataTypeEntry;
use FDevs\MoscowOpenData\Model\Package;
use FDevs\MoscowOpenData\Model\QueryFilter;

/**
 * http://api.data.mos.ru/Docs
 */
interface OpenDataInterface
{
    /**
     * Path to endpoint
     *
     * @return string
     */
    public function getEndpoint();

    /**
     * Get list of data types with basic information only
     *
     * @param QueryFilter|null $queryFilter
     * @return Package
     */
    public function getDataTypesList(QueryFilter $queryFilter = null);

    /**
     * @param int $id
     * @return DataType
     */
    public function getDataTypeFullInfo($id);

    /**
     * @param int $dataTypeId
     * @param QueryFilter|null $queryFilter
     * @return array|DataTypeEntry[]
     */
    public function getDataTypeEntries($dataTypeId, QueryFilter $queryFilter = null);
}
