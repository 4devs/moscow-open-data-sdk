#Moscow Open Data SDK

This library allows easily work with [open data of Moscow government](http://data.mos.ru/). You can find a lot of useful data there, like: markets, sport object/zones, public transport ticket zones, schools, libraries and so on.

##Installation
Add `fdevs/moscow-open-data-sdk` as a dependency to your `composer.json` file:

```shell
php composer.phar require fdevs/moscow-open-data-sdk
```

##Usage

#####Example 1: Get list of all data types

Just create an instance of `OpenData` and feed it with `ClientInterface` instance and an api key you got [here](http://api.data.mos.ru/)


```php
require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use FDevs\MoscowOpenData\Api\OpenData;
use FDevs\MoscowOpenData\Model\DataType;
use FDevs\MoscowOpenData\Model\QueryFilter;

$apiKey = '12345...';
$api = new OpenData(new Client(), $apiKey);

// here you get a `Package` with `DataType` items inside
foreach ($api->getDataTypesList()->getItems() as $dataType) {
    /** @var DataType $dataType */
    printf(
        "id: %d\ncategory: %d\ndepartment: %d\ncaption: %s\n\n",
        $dataType->getId(),
        $dataType->getCategoryId(),
        $dataType->getDepartmentId(),
        $dataType->getCaption()
    );
}
```
When we get information this way, we have only information that is printed in the example above. Output:

```
...
id: 1534
category: 14
department: 6
caption: План обустройства территорий транспортно-пересадочных узлов в 2014 году

id: 912
category: 162
department: 16
caption: Места для пикника
...
```

#####Example 2: Get full info about a data type

```php
$dataTypeId = 912; // from previous example
$dataType = $api->getDataTypeFullInfo($dataTypeId);
```

Each data type may have own generic properties. Let's take a look:

```php
echo $dataType->getDescription() . "\n";

foreach ($dataType->getGenericProperties() as $property) {
    /** @var GenericProperty $property */
    printf("type: %s, caption: %s\n", $property->getType(), $property->getCaption());
}
```
Output:
```
Места для пикника, расположенные в пределах установленных границ города Москвы
type: Photo, caption: Фотография
type: ObjectShortName, caption: Краткое название спортивного объекта
type: SportZoneName, caption: Название спортивной зоны
type: ObjectAdmArea, caption: Административный округ
type: ObjectDistrict, caption: Район
type: Address, caption: Адрес
type: Email, caption: Адрес электронной почты
type: WebSite, caption: Адрес сайта
type: HelpPhone, caption: Справочный телефон
...
```

#####Example 3: Get data type entries (Sport zones in our case)

```php
$sportZoneDataTypeId = 912;
$zones = $api->getDataTypeEntries($sportZoneDataTypeId);

foreach ($zones as $zone) {
    /** @var DataTypeEntry $zone */
    $website = $zone->hasGenericProperty('WebSite') ? $zone->getGenericProperty('WebSite')->getCaption() : '';
    $address = $zone->hasGenericProperty('Address') ? $zone->getGenericProperty('Address')->getCaption() : '';

    printf(
        "id: %s\nwebsite: %s\naddress: %s\n\n",
        $zone->getId(),
        $website,
        $address
    );
}
```

##### Filters

It's possible to apply `Query` filter to some api calls. Check `OpenDataInterface` for more details.

#####Example 4.1: Limit and offset

Query filter allows as to reduce a dataset and iterate through it.

```php
$filter = new QueryFilter();
$filter
    ->setLimit(10)
    ->setSkip(5)
;
$dataPackage = $api->getDataTypesList($filter);
```

#####Example 4.2: Inline count

It's possible to get a total records count using query filter:
```php
$filter = new QueryFilter();
$filter
    ->setLimit(5)
    ->setShowInlineCount(true)
;
$dataPackage = $api->getDataTypesList($filter);

echo $dataPackage->getTotalCount();
```

##More information
Read the documentation of [Moscow open data](http://api.data.mos.ru/Docs)

##License
This library is licensed under the MIT license
