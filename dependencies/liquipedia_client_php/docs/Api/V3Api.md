# Liquipedia\Client\V3Api

All URIs are relative to https://api.liquipedia.net/api/v3, except if the
operation defines another base path.

| Method                                                      | HTTP request               | Description                  |
| ----------------------------------------------------------- | -------------------------- | ---------------------------- |
| [**broadcastersGet()**](V3Api.md#broadcastersGet)           | **GET** /broadcasters      | Get broadcasters             |
| [**companyGet()**](V3Api.md#companyGet)                     | **GET** /company           | Get companies                |
| [**datapointGet()**](V3Api.md#datapointGet)                 | **GET** /datapoint         | Get datapoints               |
| [**externalmedialinkGet()**](V3Api.md#externalmedialinkGet) | **GET** /externalmedialink | Get media links              |
| [**matchGet()**](V3Api.md#matchGet)                         | **GET** /match             | Get matches                  |
| [**placementGet()**](V3Api.md#placementGet)                 | **GET** /placement         | Get placements               |
| [**playerGet()**](V3Api.md#playerGet)                       | **GET** /player            | Get players                  |
| [**seriesGet()**](V3Api.md#seriesGet)                       | **GET** /series            | Get series                   |
| [**squadplayerGet()**](V3Api.md#squadplayerGet)             | **GET** /squadplayer       | Get squadplayer              |
| [**standingsentryGet()**](V3Api.md#standingsentryGet)       | **GET** /standingsentry    | Get standing                 |
| [**standingstableGet()**](V3Api.md#standingstableGet)       | **GET** /standingstable    | Get standing                 |
| [**teamGet()**](V3Api.md#teamGet)                           | **GET** /team              | Get teams                    |
| [**teamtemplateGet()**](V3Api.md#teamtemplateGet)           | **GET** /teamtemplate      | Get a team template          |
| [**teamtemplatelistGet()**](V3Api.md#teamtemplatelistGet)   | **GET** /teamtemplatelist  | Get a list of team templates |
| [**tournamentGet()**](V3Api.md#tournamentGet)               | **GET** /tournament        | Get tournaments              |
| [**transferGet()**](V3Api.md#transferGet)                   | **GET** /transfer          | Get transfers                |

## `broadcastersGet()`

```php
broadcastersGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get broadcasters

Get information from the broadcasters table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->broadcastersGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->broadcastersGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `companyGet()`

```php
companyGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get companies

Get information from the company table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->companyGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->companyGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `datapointGet()`

```php
datapointGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get datapoints

Get information from the datapoint table. This information is unspecified
between wikis and can hold a variety of things.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->datapointGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->datapointGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `externalmedialinkGet()`

```php
externalmedialinkGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get media links

Get information from the externalmedialink table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->externalmedialinkGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->externalmedialinkGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `matchGet()`

```php
matchGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby, $rawstreams, $streamurls): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get matches

Get information from the match2 table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`
$rawstreams = 'false'; // string | If you want the raw stream data. Read the full documentation on how this correlates with `streamurls`.  **Example:** `true`, `false`
$streamurls = 'false'; // string | If you want to get stream urls to link to. Read the full documentation on how this correlates with `rawstreams`.  **Example:** `true`, `false`

try {
    $result = $apiInstance->matchGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby, $rawstreams, $streamurls);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->matchGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                                                                 | Notes                                   |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2                                              | counterstrike&#x60;                     |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;                                              | [optional]                              |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                                                                      | [optional]                              |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                                                                 | [optional]                              |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                                                                | [optional]                              |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                                                                    | [optional]                              |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60;                                           | [optional]                              |
| **rawstreams** | **string** | If you want the raw stream data. Read the full documentation on how this correlates with &#x60;streamurls&#x60;. **Example:** &#x60;true&#x60;, &#x60;false&#x60;           | [optional] [default to &#39;false&#39;] |
| **streamurls** | **string** | If you want to get stream urls to link to. Read the full documentation on how this correlates with &#x60;rawstreams&#x60;. **Example:** &#x60;true&#x60;, &#x60;false&#x60; | [optional] [default to &#39;false&#39;] |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `placementGet()`

```php
placementGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get placements

Get information from the placement table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->placementGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->placementGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `playerGet()`

```php
playerGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get players

Get information from the player table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->playerGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->playerGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `seriesGet()`

```php
seriesGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get series

Get information from the series table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->seriesGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->seriesGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `squadplayerGet()`

```php
squadplayerGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get squadplayer

Get information from the squadplayer table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->squadplayerGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->squadplayerGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `standingsentryGet()`

```php
standingsentryGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get standing

Get information from the standing entries table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->standingsentryGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->standingsentryGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `standingstableGet()`

```php
standingstableGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get standing

Get information from the standing table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->standingstableGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->standingstableGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `teamGet()`

```php
teamGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get teams

Get information from the team table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->teamGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->teamGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `teamtemplateGet()`

```php
teamtemplateGet($wiki, $template, $date): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get a team template

Use this to get a single team template.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wiki you want data from.  **Example:** `dota2`
$template = 'template_example'; // string | The template name of the team template you want to get.  **Example:** `teamliquid`
$date = 'date_example'; // string | Liquipedia supports historical logos, but will require the date to show them.  **Example:** `2009-06-05`

try {
    $result = $apiInstance->teamtemplateGet($wiki, $template, $date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->teamtemplateGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name         | Type       | Description                                                                                                       | Notes      |
| ------------ | ---------- | ----------------------------------------------------------------------------------------------------------------- | ---------- |
| **wiki**     | **string** | The wiki you want data from. **Example:** &#x60;dota2&#x60;                                                       |            |
| **template** | **string** | The template name of the team template you want to get. **Example:** &#x60;teamliquid&#x60;                       |            |
| **date**     | **string** | Liquipedia supports historical logos, but will require the date to show them. **Example:** &#x60;2009-06-05&#x60; | [optional] |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `teamtemplatelistGet()`

```php
teamtemplatelistGet($wiki, $pagination): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get a list of team templates

Use this to query a list of team templates in pages of 200.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wiki you want data from.  **Example:** `dota2`
$pagination = 56; // int | .  **Example:** `1`

try {
    $result = $apiInstance->teamtemplatelistGet($wiki, $pagination);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->teamtemplatelistGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                 | Notes      |
| -------------- | ---------- | ----------------------------------------------------------- | ---------- |
| **wiki**       | **string** | The wiki you want data from. **Example:** &#x60;dota2&#x60; |            |
| **pagination** | **int**    | . **Example:** &#x60;1&#x60;                                | [optional] |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `tournamentGet()`

```php
tournamentGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get tournaments

Get information from the tournament table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->tournamentGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->tournamentGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `transferGet()`

```php
transferGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby): \Liquipedia\Client\Model\BroadcastersGet200Response
```

Get transfers

Get information from the transfer table.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKeyAuth
$config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Liquipedia\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('authorization', 'Bearer');


$apiInstance = new Liquipedia\Client\Api\V3Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$wiki = 'wiki_example'; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
$conditions = 'conditions_example'; // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
$query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
$limit = 56; // int | The amount of results you want.  **Example:** `20`
$offset = 56; // int | This can be used for pagination.  **Example:** `20`
$order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
$groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

try {
    $result = $apiInstance->transferGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V3Api->transferGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name           | Type       | Description                                                                                                                       | Notes               |
| -------------- | ---------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| **wiki**       | **string** | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests. **Example:** &#x60;dota2&#x60;, &#x60;dota2    | counterstrike&#x60; |
| **conditions** | **string** | The filters you want to apply to the request. **Example:** &#x60;[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]&#x60;    | [optional]          |
| **query**      | **string** | The datapoints you want to query. **Example:** &#x60;pagename, pageid, namespace&#x60;                                            | [optional]          |
| **limit**      | **int**    | The amount of results you want. **Example:** &#x60;20&#x60;                                                                       | [optional]          |
| **offset**     | **int**    | This can be used for pagination. **Example:** &#x60;20&#x60;                                                                      | [optional]          |
| **order**      | **string** | The order you want your result in. **Example:** &#x60;pagename ASC&#x60;                                                          | [optional]          |
| **groupby**    | **string** | What you want your results grouped by (this can be helpful when using aggregate functions). **Example:** &#x60;pagename ASC&#x60; | [optional]          |

### Return type

[**\Liquipedia\Client\Model\BroadcastersGet200Response**](../Model/BroadcastersGet200Response.md)

### Authorization

[ApiKeyAuth](../../README.md#ApiKeyAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
