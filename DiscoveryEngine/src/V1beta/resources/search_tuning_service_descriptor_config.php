<?php

return [
    'interfaces' => [
        'google.cloud.discoveryengine.v1beta.SearchTuningService' => [
            'TrainCustomModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\TrainCustomModelResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\TrainCustomModelMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
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
