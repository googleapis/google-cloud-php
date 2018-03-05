<?php

return [
    'interfaces' => [
        'google.bigtable.admin.v2.BigtableInstanceAdmin' => [
            'CreateInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Bigtable\Admin\V2\Instance',
                    'metadataReturnType' => '\Google\Cloud\Bigtable\Admin\V2\CreateInstanceMetadata',
                ],
            ],
            'CreateCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Bigtable\Admin\V2\Cluster',
                    'metadataReturnType' => '\Google\Cloud\Bigtable\Admin\V2\CreateClusterMetadata',
                ],
            ],
            'UpdateCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Bigtable\Admin\V2\Cluster',
                    'metadataReturnType' => '\Google\Cloud\Bigtable\Admin\V2\UpdateClusterMetadata',
                ],
            ],
            'ListAppProfiles' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAppProfiles',
                ],
            ],
        ],
    ],
];
