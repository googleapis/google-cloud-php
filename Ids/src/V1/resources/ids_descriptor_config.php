<?php

return [
    'interfaces' => [
        'google.cloud.ids.v1.IDS' => [
            'CreateEndpoint' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Ids\V1\Endpoint',
                    'metadataReturnType' => '\Google\Cloud\Ids\V1\OperationMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '3600000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteEndpoint' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Ids\V1\OperationMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '3600000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEndpoint' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Ids\V1\Endpoint',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListEndpoints' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getEndpoints',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Ids\V1\ListEndpointsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'endpoint' => 'projects/{project}/locations/{location}/endpoints/{endpoint}',
                'location' => 'projects/{project}/locations/{location}',
            ],
        ],
    ],
];
