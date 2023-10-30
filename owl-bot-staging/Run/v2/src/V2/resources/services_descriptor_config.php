<?php

return [
    'interfaces' => [
        'google.cloud.run.v2.Services' => [
            'CreateService' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Service',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Service',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'DeleteService' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Service',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Service',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'UpdateService' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Service',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Service',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getService',
                            'getName',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetService' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Run\V2\Service',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'ListServices' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getServices',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Run\V2\ListServicesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\TestIamPermissionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'connector' => 'projects/{project}/locations/{location}/connectors/{connector}',
                'cryptoKey' => 'projects/{project}/locations/{location}/keyRings/{key_ring}/cryptoKeys/{crypto_key}',
                'location' => 'projects/{project}/locations/{location}',
                'revision' => 'projects/{project}/locations/{location}/services/{service}/revisions/{revision}',
                'secret' => 'projects/{project}/secrets/{secret}',
                'secretVersion' => 'projects/{project}/secrets/{secret}/versions/{version}',
                'service' => 'projects/{project}/locations/{location}/services/{service}',
            ],
        ],
    ],
];
