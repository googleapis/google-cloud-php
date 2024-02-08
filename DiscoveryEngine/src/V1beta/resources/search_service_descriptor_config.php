<?php

return [
    'interfaces' => [
        'google.cloud.discoveryengine.v1beta.SearchService' => [
            'Search' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getResults',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1beta\SearchResponse',
                'headerParams' => [
                    [
                        'keyName' => 'serving_config',
                        'fieldAccessors' => [
                            'getServingConfig',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'branch' => 'projects/{project}/locations/{location}/dataStores/{data_store}/branches/{branch}',
                'projectLocationCollectionDataStoreBranch' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/branches/{branch}',
                'projectLocationCollectionDataStoreServingConfig' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/servingConfigs/{serving_config}',
                'projectLocationCollectionEngineServingConfig' => 'projects/{project}/locations/{location}/collections/{collection}/engines/{engine}/servingConfigs/{serving_config}',
                'projectLocationDataStoreBranch' => 'projects/{project}/locations/{location}/dataStores/{data_store}/branches/{branch}',
                'projectLocationDataStoreServingConfig' => 'projects/{project}/locations/{location}/dataStores/{data_store}/servingConfigs/{serving_config}',
                'servingConfig' => 'projects/{project}/locations/{location}/dataStores/{data_store}/servingConfigs/{serving_config}',
            ],
        ],
    ],
];
