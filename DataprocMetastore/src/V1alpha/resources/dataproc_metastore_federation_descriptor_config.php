<?php

return [
    'interfaces' => [
        'google.cloud.metastore.v1alpha.DataprocMetastoreFederation' => [
            'CreateFederation' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Metastore\V1alpha\Federation',
                    'metadataReturnType' => '\Google\Cloud\Metastore\V1alpha\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteFederation' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Metastore\V1alpha\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateFederation' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Metastore\V1alpha\Federation',
                    'metadataReturnType' => '\Google\Cloud\Metastore\V1alpha\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListFederations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getFederations',
                ],
            ],
        ],
    ],
];
