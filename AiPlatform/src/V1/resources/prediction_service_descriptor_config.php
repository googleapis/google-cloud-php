<?php

return [
    'interfaces' => [
        'google.cloud.aiplatform.v1.PredictionService' => [
            'DirectPredict' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\DirectPredictResponse',
                'headerParams' => [
                    [
                        'keyName' => 'endpoint',
                        'fieldAccessors' => [
                            'getEndpoint',
                        ],
                    ],
                ],
            ],
            'DirectRawPredict' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\DirectRawPredictResponse',
                'headerParams' => [
                    [
                        'keyName' => 'endpoint',
                        'fieldAccessors' => [
                            'getEndpoint',
                        ],
                    ],
                ],
            ],
            'Explain' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\ExplainResponse',
                'headerParams' => [
                    [
                        'keyName' => 'endpoint',
                        'fieldAccessors' => [
                            'getEndpoint',
                        ],
                    ],
                ],
            ],
            'Predict' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\PredictResponse',
                'headerParams' => [
                    [
                        'keyName' => 'endpoint',
                        'fieldAccessors' => [
                            'getEndpoint',
                        ],
                    ],
                ],
            ],
            'RawPredict' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Api\HttpBody',
                'headerParams' => [
                    [
                        'keyName' => 'endpoint',
                        'fieldAccessors' => [
                            'getEndpoint',
                        ],
                    ],
                ],
            ],
            'ServerStreamingPredict' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\StreamingPredictResponse',
                'headerParams' => [
                    [
                        'keyName' => 'endpoint',
                        'fieldAccessors' => [
                            'getEndpoint',
                        ],
                    ],
                ],
            ],
            'StreamGenerateContent' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\GenerateContentResponse',
                'headerParams' => [
                    [
                        'keyName' => 'model',
                        'fieldAccessors' => [
                            'getModel',
                        ],
                    ],
                ],
            ],
            'StreamingPredict' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\StreamingPredictResponse',
            ],
            'StreamingRawPredict' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\StreamingRawPredictResponse',
            ],
            'GetLocation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Location\Location',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.cloud.location.Locations',
            ],
            'ListLocations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLocations',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Location\ListLocationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.cloud.location.Locations',
            ],
            'GetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'SetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'TestIamPermissions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\TestIamPermissionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'templateMap' => [
                'endpoint' => 'projects/{project}/locations/{location}/endpoints/{endpoint}',
                'projectLocationEndpoint' => 'projects/{project}/locations/{location}/endpoints/{endpoint}',
                'projectLocationPublisherModel' => 'projects/{project}/locations/{location}/publishers/{publisher}/models/{model}',
            ],
        ],
    ],
];
