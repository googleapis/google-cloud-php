<?php

return [
    'interfaces' => [
        'google.cloud.retail.v2.ServingConfigService' => [
            'AddControl' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\ServingConfig',
                'headerParams' => [
                    [
                        'keyName' => 'serving_config',
                        'fieldAccessors' => [
                            'getServingConfig',
                        ],
                    ],
                ],
            ],
            'CreateServingConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\ServingConfig',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteServingConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetServingConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\ServingConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListServingConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getServingConfigs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\ListServingConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RemoveControl' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\ServingConfig',
                'headerParams' => [
                    [
                        'keyName' => 'serving_config',
                        'fieldAccessors' => [
                            'getServingConfig',
                        ],
                    ],
                ],
            ],
            'UpdateServingConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\ServingConfig',
                'headerParams' => [
                    [
                        'keyName' => 'serving_config.name',
                        'fieldAccessors' => [
                            'getServingConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'catalog' => 'projects/{project}/locations/{location}/catalogs/{catalog}',
                'servingConfig' => 'projects/{project}/locations/{location}/catalogs/{catalog}/servingConfigs/{serving_config}',
            ],
        ],
    ],
];
