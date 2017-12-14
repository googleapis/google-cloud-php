<?php

return [
    'interfaces' => [
        'google.spanner.admin.database.v1.DatabaseAdmin' => [
            'createDatabase' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Spanner\Admin\Database\V1\Database',
                    'metadataReturnType' => '\Google\Cloud\Spanner\Admin\Database\V1\CreateDatabaseMetadata',
                ],
            ],
            'updateDatabaseDdl' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Spanner\Admin\Database\V1\UpdateDatabaseDdlMetadata',
                ],
            ],
            'listDatabases' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDatabases',
                ],
            ],
        ],
    ],
];
