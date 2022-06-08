<?php

return [
    'interfaces' => [
        'google.cloud.domains.v1beta1.Domains' => [
            'ConfigureContactSettings' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ConfigureDnsSettings' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ConfigureManagementSettings' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteRegistration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ExportRegistration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'RegisterDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'TransferDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateRegistration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListRegistrations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getRegistrations',
                ],
            ],
        ],
    ],
];
