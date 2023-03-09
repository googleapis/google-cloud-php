<?php

return [
    'interfaces' => [
        'google.cloud.dataproc.v1.NodeGroupController' => [
            'CreateNodeGroup' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dataproc\V1\NodeGroup',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\NodeGroupOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ResizeNodeGroup' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dataproc\V1\NodeGroup',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\NodeGroupOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
        ],
    ],
];
