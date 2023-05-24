<?php

return [
    'interfaces' => [
        'google.cloud.gaming.v1.GameServerClustersService' => [
            'CreateGameServerCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Gaming\V1\GameServerCluster',
                    'metadataReturnType' => '\Google\Cloud\Gaming\V1\OperationMetadata',
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
            'DeleteGameServerCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Gaming\V1\OperationMetadata',
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
            'UpdateGameServerCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Gaming\V1\GameServerCluster',
                    'metadataReturnType' => '\Google\Cloud\Gaming\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'game_server_cluster.name',
                        'fieldAccessors' => [
                            'getGameServerCluster',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGameServerCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Gaming\V1\GameServerCluster',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListGameServerClusters' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getGameServerClusters',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Gaming\V1\ListGameServerClustersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PreviewCreateGameServerCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Gaming\V1\PreviewCreateGameServerClusterResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PreviewDeleteGameServerCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Gaming\V1\PreviewDeleteGameServerClusterResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'PreviewUpdateGameServerCluster' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Gaming\V1\PreviewUpdateGameServerClusterResponse',
                'headerParams' => [
                    [
                        'keyName' => 'game_server_cluster.name',
                        'fieldAccessors' => [
                            'getGameServerCluster',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'gameServerCluster' => 'projects/{project}/locations/{location}/realms/{realm}/gameServerClusters/{cluster}',
                'realm' => 'projects/{project}/locations/{location}/realms/{realm}',
            ],
        ],
    ],
];
