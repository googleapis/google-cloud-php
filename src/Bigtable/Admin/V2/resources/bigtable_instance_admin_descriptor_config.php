<?php

return [
    'interfaces' => [
        'google.bigtable.admin.v2.BigtableInstanceAdmin' => [
            'createInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Bigtable\Admin\V2\Instance',
                    'metadataReturnType' => '\Google\Cloud\Bigtable\Admin\V2\CreateInstanceMetadata',
                ],
            ],
            'createCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Bigtable\Admin\V2\Cluster',
                    'metadataReturnType' => '\Google\Cloud\Bigtable\Admin\V2\CreateClusterMetadata',
                ],
            ],
            'updateCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Bigtable\Admin\V2\Cluster',
                    'metadataReturnType' => '\Google\Cloud\Bigtable\Admin\V2\UpdateClusterMetadata',
                ],
            ],
            'listAppProfiles' => [
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
