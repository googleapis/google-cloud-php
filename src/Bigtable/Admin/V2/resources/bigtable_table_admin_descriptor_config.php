<?php

return [
    'interfaces' => [
        'google.bigtable.admin.v2.BigtableTableAdmin' => [
            'createTableFromSnapshot' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Bigtable\Admin\V2\Table',
                    'metadataReturnType' => '\Google\Cloud\Bigtable\Admin\V2\CreateTableFromSnapshotMetadata',
                ],
            ],
            'listTables' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTables',
                ],
            ],
            'listSnapshots' => [
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
