<?php

return [
    'interfaces' => [
        'google.api.apikeys.v2.ApiKeys' => [
            'CreateKey' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ApiKeys\V2\Key',
                    'metadataReturnType' => '\Google\Protobuf\GPBEmpty',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
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
            'DeleteKey' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ApiKeys\V2\Key',
                    'metadataReturnType' => '\Google\Protobuf\GPBEmpty',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
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
            'UndeleteKey' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ApiKeys\V2\Key',
                    'metadataReturnType' => '\Google\Protobuf\GPBEmpty',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
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
            'UpdateKey' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ApiKeys\V2\Key',
                    'metadataReturnType' => '\Google\Protobuf\GPBEmpty',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'key.name',
                        'fieldAccessors' => [
                            'getKey',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetKey' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ApiKeys\V2\Key',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetKeyString' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ApiKeys\V2\GetKeyStringResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListKeys' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getKeys',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ApiKeys\V2\ListKeysResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LookupKey' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ApiKeys\V2\LookupKeyResponse',
            ],
            'templateMap' => [
                'key' => 'projects/{project}/locations/{location}/keys/{key}',
                'location' => 'projects/{project}/locations/{location}',
            ],
        ],
    ],
];
