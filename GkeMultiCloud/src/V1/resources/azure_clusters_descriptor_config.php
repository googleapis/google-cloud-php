<?php

return [
    'interfaces' => [
        'google.cloud.gkemulticloud.v1.AzureClusters' => [
            'CreateAzureClient' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AzureClient',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
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
            'CreateAzureCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AzureCluster',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
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
            'CreateAzureNodePool' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AzureNodePool',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
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
            'DeleteAzureClient' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAzureCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAzureNodePool' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAzureCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AzureCluster',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'azure_cluster.name',
                        'fieldAccessors' => [
                            'getAzureCluster',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAzureNodePool' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AzureNodePool',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'azure_node_pool.name',
                        'fieldAccessors' => [
                            'getAzureNodePool',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateAzureAccessToken' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\GenerateAzureAccessTokenResponse',
                'headerParams' => [
                    [
                        'keyName' => 'azure_cluster',
                        'fieldAccessors' => [
                            'getAzureCluster',
                        ],
                    ],
                ],
            ],
            'GenerateAzureClusterAgentToken' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\GenerateAzureClusterAgentTokenResponse',
                'headerParams' => [
                    [
                        'keyName' => 'azure_cluster',
                        'fieldAccessors' => [
                            'getAzureCluster',
                        ],
                    ],
                ],
            ],
            'GetAzureClient' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AzureClient',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAzureCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AzureCluster',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAzureJsonWebKeys' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AzureJsonWebKeys',
                'headerParams' => [
                    [
                        'keyName' => 'azure_cluster',
                        'fieldAccessors' => [
                            'getAzureCluster',
                        ],
                    ],
                ],
            ],
            'GetAzureNodePool' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AzureNodePool',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAzureOpenIdConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AzureOpenIdConfig',
                'headerParams' => [
                    [
                        'keyName' => 'azure_cluster',
                        'fieldAccessors' => [
                            'getAzureCluster',
                        ],
                    ],
                ],
            ],
            'GetAzureServerConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AzureServerConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAzureClients' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAzureClients',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\ListAzureClientsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAzureClusters' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAzureClusters',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\ListAzureClustersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAzureNodePools' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAzureNodePools',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\ListAzureNodePoolsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'azureClient' => 'projects/{project}/locations/{location}/azureClients/{azure_client}',
                'azureCluster' => 'projects/{project}/locations/{location}/azureClusters/{azure_cluster}',
                'azureNodePool' => 'projects/{project}/locations/{location}/azureClusters/{azure_cluster}/azureNodePools/{azure_node_pool}',
                'azureServerConfig' => 'projects/{project}/locations/{location}/azureServerConfig',
                'location' => 'projects/{project}/locations/{location}',
            ],
        ],
    ],
];
