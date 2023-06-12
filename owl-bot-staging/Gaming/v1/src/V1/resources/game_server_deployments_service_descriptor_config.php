<?php

return [
    'interfaces' => [
        'google.cloud.gaming.v1.GameServerDeploymentsService' => [
            'CreateGameServerDeployment' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Gaming\V1\GameServerDeployment',
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
            'DeleteGameServerDeployment' => [
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
            'UpdateGameServerDeployment' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Gaming\V1\GameServerDeployment',
                    'metadataReturnType' => '\Google\Cloud\Gaming\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'game_server_deployment.name',
                        'fieldAccessors' => [
                            'getGameServerDeployment',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGameServerDeploymentRollout' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Gaming\V1\GameServerDeployment',
                    'metadataReturnType' => '\Google\Cloud\Gaming\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'rollout.name',
                        'fieldAccessors' => [
                            'getRollout',
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchDeploymentState' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Gaming\V1\FetchDeploymentStateResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGameServerDeployment' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Gaming\V1\GameServerDeployment',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGameServerDeploymentRollout' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Gaming\V1\GameServerDeploymentRollout',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListGameServerDeployments' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getGameServerDeployments',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Gaming\V1\ListGameServerDeploymentsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PreviewGameServerDeploymentRollout' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Gaming\V1\PreviewGameServerDeploymentRolloutResponse',
                'headerParams' => [
                    [
                        'keyName' => 'rollout.name',
                        'fieldAccessors' => [
                            'getRollout',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'gameServerDeployment' => 'projects/{project}/locations/{location}/gameServerDeployments/{deployment}',
                'gameServerDeploymentRollout' => 'projects/{project}/locations/{location}/gameServerDeployments/{deployment}/rollout',
                'location' => 'projects/{project}/locations/{location}',
            ],
        ],
    ],
];
