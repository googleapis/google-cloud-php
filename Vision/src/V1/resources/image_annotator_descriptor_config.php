<?php

return [
    'interfaces' => [
        'google.cloud.vision.v1.ImageAnnotator' => [
            'AsyncBatchAnnotateImages' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Vision\V1\AsyncBatchAnnotateImagesResponse',
                    'metadataReturnType' => '\Google\Cloud\Vision\V1\OperationMetadata',
                    'initialPollDelayMillis' => '20000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '86400000',
                ],
            ],
            'AsyncBatchAnnotateFiles' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Vision\V1\AsyncBatchAnnotateFilesResponse',
                    'metadataReturnType' => '\Google\Cloud\Vision\V1\OperationMetadata',
                    'initialPollDelayMillis' => '20000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '86400000',
                ],
            ],
        ],
    ],
];
