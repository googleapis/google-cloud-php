<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.TargetHttpProxies' => [
            'Delete' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
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
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'target_http_proxy',
                        'fieldAccessors' => [
                            'getTargetHttpProxy',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
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
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
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
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'target_http_proxy',
                        'fieldAccessors' => [
                            'getTargetHttpProxy',
                        ],
                    ],
                ],
            ],
            'SetUrlMap' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
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
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'target_http_proxy',
                        'fieldAccessors' => [
                            'getTargetHttpProxy',
                        ],
                    ],
                ],
            ],
            'AggregatedList' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getMaxResults',
                    'requestPageSizeSetMethod' => 'setMaxResults',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getItems',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\TargetHttpProxyAggregatedList',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\TargetHttpProxy',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'target_http_proxy',
                        'fieldAccessors' => [
                            'getTargetHttpProxy',
                        ],
                    ],
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
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\TargetHttpProxyList',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
