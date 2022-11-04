<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.RegionTargetHttpsProxies' => [
            'Delete' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getRegion',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
            ],
            'Insert' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getRegion',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
            ],
            'Patch' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getRegion',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
            ],
            'SetSslCertificates' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getRegion',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
            ],
            'SetUrlMap' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getRegion',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
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
        ],
    ],
];
