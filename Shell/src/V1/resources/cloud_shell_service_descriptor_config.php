<?php

return [
    'interfaces' => [
        'google.cloud.shell.v1.CloudShellService' => [
            'AddPublicKey' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Shell\V1\AddPublicKeyResponse',
                    'metadataReturnType' => '\Google\Cloud\Shell\V1\AddPublicKeyMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'environment',
                        'fieldAccessors' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'AuthorizeEnvironment' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Shell\V1\AuthorizeEnvironmentResponse',
                    'metadataReturnType' => '\Google\Cloud\Shell\V1\AuthorizeEnvironmentMetadata',
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
            'RemovePublicKey' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Shell\V1\RemovePublicKeyResponse',
                    'metadataReturnType' => '\Google\Cloud\Shell\V1\RemovePublicKeyMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'environment',
                        'fieldAccessors' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'StartEnvironment' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Shell\V1\StartEnvironmentResponse',
                    'metadataReturnType' => '\Google\Cloud\Shell\V1\StartEnvironmentMetadata',
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
            'GetEnvironment' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Shell\V1\Environment',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'environment' => 'users/{user}/environments/{environment}',
            ],
        ],
    ],
];
