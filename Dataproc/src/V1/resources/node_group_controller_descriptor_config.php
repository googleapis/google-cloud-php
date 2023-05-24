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
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
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
            'GetNodeGroup' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dataproc\V1\NodeGroup',
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
                'clusterRegion' => 'projects/{project}/regions/{region}/clusters/{cluster}',
                'nodeGroup' => 'projects/{project}/regions/{region}/clusters/{cluster}/nodeGroups/{node_group}',
            ],
        ],
    ],
];
