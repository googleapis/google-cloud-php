<?php

return [
    'interfaces' => [
        'google.cloud.documentai.v1beta2.DocumentUnderstandingService' => [
            'BatchProcessDocuments' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DocumentAI\V1beta2\BatchProcessDocumentsResponse',
                    'metadataReturnType' => '\Google\Cloud\DocumentAI\V1beta2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
        ],
    ],
];
