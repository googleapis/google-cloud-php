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
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'Predict' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AutoMl\V1\PredictResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'model' => 'projects/{project}/locations/{location}/models/{model}',
            ],
        ],
    ],
];
