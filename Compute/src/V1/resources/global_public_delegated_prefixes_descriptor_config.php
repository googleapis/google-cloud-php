<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.GlobalPublicDelegatedPrefixes' => [
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
                        'keyName' => 'public_delegated_prefix',
                        'fieldAccessors' => [
                            'getPublicDelegatedPrefix',
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
                        'keyName' => 'public_delegated_prefix',
                        'fieldAccessors' => [
                            'getPublicDelegatedPrefix',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\PublicDelegatedPrefix',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'public_delegated_prefix',
                        'fieldAccessors' => [
                            'getPublicDelegatedPrefix',
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
                'responseType' => 'Google\Cloud\Compute\V1\PublicDelegatedPrefixList',
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
