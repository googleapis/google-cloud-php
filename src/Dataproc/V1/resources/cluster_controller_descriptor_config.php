<?php

return [
    'interfaces' => [
        'google.cloud.dataproc.v1.ClusterController' => [
            'CreateCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dataproc\V1\Cluster',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\ClusterOperationMetadata',
                ]
            ],
            'UpdateCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dataproc\V1\Cluster',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\ClusterOperationMetadata',
                ]
            ],
            'DeleteCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\ClusterOperationMetadata',
                ]
            ],
            'DiagnoseCluster' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\DiagnoseClusterResults',
                ]
            ],
            'ListClusters' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getClusters'
                ]
            ],
        ]
    ]
];