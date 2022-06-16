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
        ],
    ],
];
