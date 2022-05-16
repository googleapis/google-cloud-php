<?php

return [
    'interfaces' => [
        'google.cloud.optimization.v1.FleetRouting' => [
            'BatchOptimizeTours' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Optimization\V1\BatchOptimizeToursResponse',
                    'metadataReturnType' => '\Google\Cloud\Optimization\V1\AsyncModelMetadata',
                    'initialPollDelayMillis' => '30000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '120000',
                    'totalPollTimeoutMillis' => '3600000',
                ],
            ],
        ],
    ],
];
