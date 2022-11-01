<?php

return [
    'interfaces' => [
        'google.cloud.vision.v1.ImageAnnotator' => [
            'AsyncBatchAnnotateFiles' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Vision\V1\AsyncBatchAnnotateFilesResponse',
                    'metadataReturnType' => '\Google\Cloud\Vision\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'AsyncBatchAnnotateImages' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Vision\V1\AsyncBatchAnnotateImagesResponse',
                    'metadataReturnType' => '\Google\Cloud\Vision\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
        ],
    ],
];
