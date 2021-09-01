<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.Instances' => [
            'AggregatedList' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getMaxResults',
                    'requestPageSizeSetMethod' => 'setMaxResults',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getItems',
                ],
            ],
            'List' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getMaxResults',
                    'requestPageSizeSetMethod' => 'setMaxResults',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getItems',
                ],
            ],
            'ListReferrers' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getMaxResults',
                    'requestPageSizeSetMethod' => 'setMaxResults',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getItems',
                ],
            ],
            'Delete' => [
                'longRunning' => [
                    'getOperationMethod' => 'get',
                    'deleteOperationMethod' => 'delete',
                    'cancelOperationMethod' => null,
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone'
                    ],
                    'operationDoneMethod' => 'getStatus',
                    'operationDoneValue'  => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
            ],
        ],
    ],
];
