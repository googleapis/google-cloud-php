<?php

return [
    'interfaces' => [
        'google.bigtable.admin.v2.BigtableTableAdmin' => [
            'CreateTableFromSnapshot' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Bigtable\Admin\V2\Table',
                    'metadataReturnType' => '\Google\Cloud\Bigtable\Admin\V2\CreateTableFromSnapshotMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '60000',
                    'totalPollTimeoutMillis' => '3600000',
                ],
            ],
            'SnapshotTable' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Bigtable\Admin\V2\Snapshot',
                    'metadataReturnType' => '\Google\Cloud\Bigtable\Admin\V2\SnapshotTableMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '600000',
                ],
            ],
            'ListTables' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTables',
                ],
            ],
            'ListSnapshots' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSnapshots',
                ],
            ],
        ],
    ],
];
