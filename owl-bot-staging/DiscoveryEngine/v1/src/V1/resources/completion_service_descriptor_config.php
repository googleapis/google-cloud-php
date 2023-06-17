<?php

return [
    'interfaces' => [
        'google.cloud.discoveryengine.v1.CompletionService' => [
            'CompleteQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\CompleteQueryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'data_store',
                        'fieldAccessors' => [
                            'getDataStore',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'dataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'projectLocationCollectionDataStore' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}',
                'projectLocationDataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
            ],
        ],
    ],
];
