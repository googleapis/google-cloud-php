<?php

return [
    'interfaces' => [
        'google.cloud.documentai.v1beta3.DocumentProcessorService' => [
            'BatchProcessDocuments' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DocumentAI\V1beta3\BatchProcessResponse',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1beta3\BatchProcessMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteProcessor' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1beta3\DeleteProcessorMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DisableProcessor' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DocumentAI\V1beta3\DisableProcessorResponse',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1beta3\DisableProcessorMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'EnableProcessor' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DocumentAI\V1beta3\EnableProcessorResponse',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1beta3\EnableProcessorMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ReviewDocument' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DocumentAI\V1beta3\ReviewDocumentResponse',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1beta3\ReviewDocumentOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
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
        ],
    ],
];
