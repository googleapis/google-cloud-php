<?php

return [
    'interfaces' => [
        'google.dataflow.v1beta3.SnapshotsV1Beta3' => [
            'DeleteSnapshot' => [
                'method' => 'delete',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/snapshots/{snapshot_id}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1b3/projects/{project_id}/snapshots',
                    ],
                ],
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'snapshot_id' => [
                        'getters' => [
                            'getSnapshotId',
                        ],
                    ],
                ],
            ],
            'GetSnapshot' => [
                'method' => 'get',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/snapshots/{snapshot_id}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1b3/projects/{project_id}/snapshots/{snapshot_id}',
                    ],
                ],
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'snapshot_id' => [
                        'getters' => [
                            'getSnapshotId',
                        ],
                    ],
                ],
            ],
            'ListSnapshots' => [
                'method' => 'get',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/jobs/{job_id}/snapshots',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/snapshots',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1b3/projects/{project_id}/snapshots',
                    ],
                ],
                'placeholders' => [
                    'job_id' => [
                        'getters' => [
                            'getJobId',
                        ],
                    ],
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
