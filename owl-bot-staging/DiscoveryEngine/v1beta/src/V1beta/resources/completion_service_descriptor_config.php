<?php

return [
    'interfaces' => [
        'google.cloud.discoveryengine.v1beta.CompletionService' => [
            'ImportSuggestionDenyListEntries' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\ImportSuggestionDenyListEntriesResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\ImportSuggestionDenyListEntriesMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PurgeSuggestionDenyListEntries' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\PurgeSuggestionDenyListEntriesResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\PurgeSuggestionDenyListEntriesMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CompleteQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1beta\CompleteQueryResponse',
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
