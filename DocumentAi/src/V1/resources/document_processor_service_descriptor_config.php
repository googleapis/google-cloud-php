<?php

return [
    'interfaces' => [
        'google.cloud.documentai.v1.DocumentProcessorService' => [
            'BatchProcessDocuments' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DocumentAI\V1\BatchProcessResponse',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1\BatchProcessMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteProcessor' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1\DeleteProcessorMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteProcessorVersion' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1\DeleteProcessorVersionMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeployProcessorVersion' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DocumentAI\V1\DeployProcessorVersionResponse',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1\DeployProcessorVersionMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DisableProcessor' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DocumentAI\V1\DisableProcessorResponse',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1\DisableProcessorMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'EnableProcessor' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DocumentAI\V1\EnableProcessorResponse',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1\EnableProcessorMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ReviewDocument' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DocumentAI\V1\ReviewDocumentResponse',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1\ReviewDocumentOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'SetDefaultProcessorVersion' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DocumentAI\V1\SetDefaultProcessorVersionResponse',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1\SetDefaultProcessorVersionMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UndeployProcessorVersion' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DocumentAI\V1\UndeployProcessorVersionResponse',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1\UndeployProcessorVersionMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListProcessorTypes' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getProcessorTypes',
                ],
            ],
            'ListProcessorVersions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getProcessorVersions',
                ],
            ],
            'ListProcessors' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getProcessors',
                ],
            ],
            'ListLocations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLocations',
                ],
            ],
        ],
    ],
];
