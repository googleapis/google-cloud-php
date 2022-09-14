<?php

return [
    'interfaces' => [
        'google.appengine.v1.DomainMappings' => [
            'CreateDomainMapping' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AppEngine\V1\DomainMapping',
                    'metadataReturnType' => '\Google\Cloud\AppEngine\V1\OperationMetadataV1',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteDomainMapping' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\AppEngine\V1\OperationMetadataV1',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateDomainMapping' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AppEngine\V1\DomainMapping',
                    'metadataReturnType' => '\Google\Cloud\AppEngine\V1\OperationMetadataV1',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListDomainMappings' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDomainMappings',
                ],
            ],
        ],
    ],
];
