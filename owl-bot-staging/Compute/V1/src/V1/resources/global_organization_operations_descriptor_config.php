<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.GlobalOrganizationOperations' => [
            'Delete' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\DeleteGlobalOrganizationOperationResponse',
                'headerParams' => [
                    [
                        'keyName' => 'operation',
                        'fieldAccessors' => [
                            'getOperation',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'operation',
                        'fieldAccessors' => [
                            'getOperation',
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
                'responseType' => 'Google\Cloud\Compute\V1\OperationList',
            ],
        ],
    ],
];
