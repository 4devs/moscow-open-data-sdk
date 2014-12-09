<?php

namespace FDevs\MoscowOpenData\Api;

use FDevs\MoscowOpenData\Api\Exception\ApiException;
use FDevs\MoscowOpenData\Model\DataType;
use FDevs\MoscowOpenData\Model\DataTypeEntry;
use FDevs\MoscowOpenData\Model\GenericProperty;
use FDevs\MoscowOpenData\Model\Package;
use FDevs\MoscowOpenData\Model\QueryFilter;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

class OpenData implements OpenDataInterface
{
    /**
     * @var string
     */
    private $endpoint = 'http://api.data.mos.ru/v1/';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @param ClientInterface $httpClient
     * @param string $apiKey
     * @param string|null $endpoint Path to endpoint
     */
    public function __construct(ClientInterface $httpClient, $apiKey, $endpoint = null)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = $httpClient;
        $this->httpClient->setDefaultOption('query', ['api_key' => $this->apiKey]);

        if ($endpoint) {
            $this->endpoint = $this->normalizeEndpoint($endpoint);
        }
    }

    /**
     * @param QueryFilter|null $filter
     * @return Package
     * @throws ApiException
     */
    public function getDataTypesList(QueryFilter $filter = null)
    {
        $shortDataTypes = [];
        $response = $this->sendRequest($this->getDataTypesEndpoint(), $filter);
        $package = new Package();

        if ($filter && $filter->getShowInlineCount()) {
            $package->setTotalCount($response['Count']);
            $response = $response['Items'];
        }

        foreach ($response as $dataType) {
            $shortDataType = new DataType();
            $shortDataType
                ->setId($dataType['Id'])
                ->setCaption($dataType['Caption'])
                ->setCategoryId($dataType['CategoryId'])
                ->setDepartmentId($dataType['DepartmentId'])
            ;
            $shortDataTypes[] = $shortDataType;
        }

        return $package->setItems($shortDataTypes);
    }

    /**
     * @param int $id
     * @return DataType
     * @throws ApiException
     */
    public function getDataTypeFullInfo($id)
    {
        $response = $this->sendRequest($this->getDataTypeInfoEndpoint($id));
        $dataType = new DataType();
        $dataType
            ->setId($response['Id'])
            ->setCategoryId($response['CategoryId'])
            ->setCategoryCaption($response['CategoryCaption'])
            ->setDepartmentId($response['DepartmentId'])
            ->setDepartmentCaption($response['DepartmentCaption'])
            ->setCaption($response['Caption'])
            ->setDescription($response['Description'])
            ->setHasGeodata($response['ContainsGeodata'])
        ;

        if (!empty($response['Columns'])) {
            $properties = [];
            foreach ($response['Columns'] as $column) {
                $property = new GenericProperty();
                $property
                    ->setType($column['Name'])
                    ->setCaption($column['Caption'])
                    ->setVisible($column['Visible'])
                ;
                $properties[] = $property;
            }
            $dataType->setGenericProperties($properties);
        }

        return $dataType;
    }

    /**
     * @param int $dataTypeId
     * @param QueryFilter|null $filter
     * @return array|DataTypeEntry[]
     * @throws ApiException
     */
    public function getDataTypeEntries($dataTypeId, QueryFilter $filter = null)
    {
        $entries = [];
        $response = $this->sendRequest($this->getDataTypeEntriesEndpoint($dataTypeId), $filter);

        foreach ($response as $dataEntry) {
            $entry = new DataTypeEntry();
            $entry
                ->setId($dataEntry['Id'])
                ->setNumber($dataEntry['Number'])
            ;

            $properties = [];
            foreach ($dataEntry['Cells'] as $cellType => $caption) {
                $property = new GenericProperty();
                $property
                    ->setCaption($caption)
                    ->setType($cellType)
                ;
                $properties[] = $property;
            }
            $entry->setGenericProperties($properties);
            $entries[] = $entry;
        }

        return $entries;
    }

    /**
     * Path to endpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $path
     * @param QueryFilter $filter
     * @param string $method HTTP method
     * @return array
     * @throws Exception\ApiException
     */
    private function sendRequest($path, QueryFilter $filter = null, $method = 'GET')
    {
        try {
            $response = $this->httpClient->send($this->httpClient->createRequest($method, $path, [
                'query' => $filter ? $this->filterToQueryParams($filter) : []
            ]));
            return $response->json();
        } catch (RequestException $exception) {
            throw new ApiException($exception->getMessage(), $exception->getCode(), $exception);
        } catch (\RuntimeException $exception) {
            throw new ApiException($exception->getMessage());
        }
    }

    /**
     * @return string
     */
    private function getDataTypesEndpoint()
    {
        return $this->endpoint . 'datasets';
    }

    /**
     * @param int $id
     * @return string
     */
    private function getDataTypeInfoEndpoint($id)
    {
        return sprintf('%s/%d', $this->getDataTypesEndpoint(), $id);
    }

    /**
     * @param int $dataTypeId
     * @return string
     */
    private function getDataTypeEntriesEndpoint($dataTypeId)
    {
        return $this->getDataTypeInfoEndpoint($dataTypeId) . '/rows';
    }

    /**
     * @param string $endpoint
     * @return string
     */
    private function normalizeEndpoint($endpoint)
    {
        if (substr($endpoint, strlen($endpoint) - 1) !== '/') {
            $endpoint .= '/';
        }

        return $endpoint;
    }

    /**
     * Convert a filter to query params
     *
     * @param QueryFilter $filter
     * @return array Prepared query params accordingly to Open data api specs
     */
    private function filterToQueryParams(QueryFilter $filter)
    {
        $queryParams = [];

        if ($filter->getSkip() > 0) {
            $queryParams['$skip'] = $filter->getSkip();
        }

        if ($filter->getLimit() > 0) {
            $queryParams['$top'] = $filter->getLimit();
        }

        if ($filter->getShowInlineCount()) {
            $queryParams['$inlinecount'] = 'allpages';
        }

        if ($filter->getOrderBy()) {
            $queryParams['$orderby'] = $filter->getOrderBy();
        }

        return $queryParams;
    }
}
