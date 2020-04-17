<?php

return [
    'interfaces' => [
        'google.cloud.automl.v1.PredictionService' => [
            'BatchPredict' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AutoMl\V1\BatchPredictResult',
                    'metadataReturnType' => '\Google\Cloud\AutoMl\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
        ],
    ],
];
