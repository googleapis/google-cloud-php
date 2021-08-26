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
            ],
        ],
    ],
];
