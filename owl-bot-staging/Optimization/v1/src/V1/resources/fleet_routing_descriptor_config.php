<?php

return [
    'interfaces' => [
        'google.cloud.optimization.v1.FleetRouting' => [
            'BatchOptimizeTours' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Optimization\V1\BatchOptimizeToursResponse',
                    'metadataReturnType' => '\Google\Cloud\Optimization\V1\AsyncModelMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
        ],
    ],
];
