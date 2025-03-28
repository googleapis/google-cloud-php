<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

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
            'GenerateContent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
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
            'StreamDirectPredict' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\StreamDirectPredictResponse',
            ],
            'StreamDirectRawPredict' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\StreamDirectRawPredictResponse',
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
            'StreamRawPredict' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
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
                'cachedContent' => 'projects/{project}/locations/{location}/cachedContents/{cached_content}',
                'endpoint' => 'projects/{project}/locations/{location}/endpoints/{endpoint}',
                'projectLocationEndpoint' => 'projects/{project}/locations/{location}/endpoints/{endpoint}',
                'projectLocationPublisherModel' => 'projects/{project}/locations/{location}/publishers/{publisher}/models/{model}',
                'ragCorpus' => 'projects/{project}/locations/{location}/ragCorpora/{rag_corpus}',
            ],
        ],
    ],
];
