<?php

return [
    'interfaces' => [
        'google.cloud.gkemulticloud.v1.AttachedClusters' => [
            'CreateAttachedCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AttachedCluster',
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
            'DeleteAttachedCluster' => [
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
            'ImportAttachedCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AttachedCluster',
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
            'UpdateAttachedCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\GkeMultiCloud\V1\AttachedCluster',
                    'metadataReturnType' => '\Google\Cloud\GkeMultiCloud\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'attached_cluster.name',
                        'fieldAccessors' => [
                            'getAttachedCluster',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateAttachedClusterAgentToken' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterAgentTokenResponse',
                'headerParams' => [
                    [
                        'keyName' => 'attached_cluster',
                        'fieldAccessors' => [
                            'getAttachedCluster',
                        ],
                    ],
                ],
            ],
            'GenerateAttachedClusterInstallManifest' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterInstallManifestResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetAttachedCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AttachedCluster',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAttachedServerConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\AttachedServerConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAttachedClusters' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAttachedClusters',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\GkeMultiCloud\V1\ListAttachedClustersResponse',
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
                'attachedCluster' => 'projects/{project}/locations/{location}/attachedClusters/{attached_cluster}',
                'attachedServerConfig' => 'projects/{project}/locations/{location}/attachedServerConfig',
                'location' => 'projects/{project}/locations/{location}',
            ],
        ],
    ],
];
