<?php

return [
    'interfaces' => [
        'google.dataflow.v1beta3.SnapshotsV1Beta3' => [
            'DeleteSnapshot' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dataflow\V1beta3\DeleteSnapshotResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getLocation',
                        ],
                    ],
                    [
                        'keyName' => 'snapshot_id',
                        'fieldAccessors' => [
                            'getSnapshotId',
                        ],
                    ],
                ],
            ],
            'GetSnapshot' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dataflow\V1beta3\Snapshot',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'snapshot_id',
                        'fieldAccessors' => [
                            'getSnapshotId',
                        ],
                    ],
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'ListSnapshots' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dataflow\V1beta3\ListSnapshotsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getLocation',
                        ],
                    ],
                    [
                        'keyName' => 'job_id',
                        'fieldAccessors' => [
                            'getJobId',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
