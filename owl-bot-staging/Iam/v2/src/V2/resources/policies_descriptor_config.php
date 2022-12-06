<?php

return [
    'interfaces' => [
        'google.iam.v2.Policies' => [
            'CreatePolicy' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Iam\V2\Policy',
                    'metadataReturnType' => '\Google\Cloud\Iam\V2\PolicyOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeletePolicy' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Iam\V2\Policy',
                    'metadataReturnType' => '\Google\Cloud\Iam\V2\PolicyOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdatePolicy' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Iam\V2\Policy',
                    'metadataReturnType' => '\Google\Cloud\Iam\V2\PolicyOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListPolicies' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getPolicies',
                ],
            ],
        ],
    ],
];
