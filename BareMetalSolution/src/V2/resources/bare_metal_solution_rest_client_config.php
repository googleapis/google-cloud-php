<?php

return [
    'interfaces' => [
        'google.cloud.baremetalsolution.v2.BareMetalSolution' => [
            'CreateSnapshotSchedulePolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/snapshotSchedulePolicies',
                'body' => 'snapshot_schedule_policy',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'snapshot_schedule_policy_id',
                ],
            ],
            'CreateVolumeSnapshot' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/volumes/*}/snapshots',
                'body' => 'volume_snapshot',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteSnapshotSchedulePolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/snapshotSchedulePolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteVolumeSnapshot' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*/snapshots/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInstance' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLun' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*/luns/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNetwork' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/networks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSnapshotSchedulePolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/snapshotSchedulePolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVolume' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVolumeSnapshot' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*/snapshots/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListInstances' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/instances',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListLuns' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/volumes/*}/luns',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNetworks' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/networks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSnapshotSchedulePolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/snapshotSchedulePolicies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVolumeSnapshots' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/volumes/*}/snapshots',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVolumes' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/volumes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ResetInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}:reset',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RestoreVolumeSnapshot' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{volume_snapshot=projects/*/locations/*/volumes/*/snapshots/*}:restoreVolumeSnapshot',
                'body' => '*',
                'placeholders' => [
                    'volume_snapshot' => [
                        'getters' => [
                            'getVolumeSnapshot',
                        ],
                    ],
                ],
            ],
            'UpdateSnapshotSchedulePolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{snapshot_schedule_policy.name=projects/*/locations/*/snapshotSchedulePolicies/*}',
                'body' => 'snapshot_schedule_policy',
                'placeholders' => [
                    'snapshot_schedule_policy.name' => [
                        'getters' => [
                            'getSnapshotSchedulePolicy',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateVolume' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{volume.name=projects/*/locations/*/volumes/*}',
                'body' => 'volume',
                'placeholders' => [
                    'volume.name' => [
                        'getters' => [
                            'getVolume',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*}/operations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
