<?php
/*
 * Copyright 2025 Google LLC
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
        'google.showcase.v1beta1.Echo' => [
            'Wait' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Showcase\V1beta1\WaitResponse',
                    'metadataReturnType' => '\Google\Showcase\V1beta1\WaitMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
            ],
            'Block' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\BlockResponse',
            ],
            'Chat' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Showcase\V1beta1\EchoResponse',
            ],
            'Collect' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ClientStreaming',
                ],
                'callType' => \Google\ApiCore\Call::CLIENT_STREAMING_CALL,
                'responseType' => 'Google\Showcase\V1beta1\EchoResponse',
            ],
            'Echo' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\EchoResponse',
                'headerParams' => [
                    [
                        'keyName' => 'header',
                        'fieldAccessors' => [
                            'getHeader',
                        ],
                    ],
                    [
                        'keyName' => 'routing_id',
                        'fieldAccessors' => [
                            'getHeader',
                        ],
                    ],
                    [
                        'keyName' => 'table_name',
                        'fieldAccessors' => [
                            'getHeader',
                        ],
                        'matchers' => [
                            '/^(?<table_name>regions\/[^\/]+\/zones\/[^\/]+(?:\/.*)?)$/',
                            '/^(?<table_name>projects\/[^\/]+\/instances\/[^\/]+(?:\/.*)?)$/',
                        ],
                    ],
                    [
                        'keyName' => 'super_id',
                        'fieldAccessors' => [
                            'getHeader',
                        ],
                        'matchers' => [
                            '/^(?<super_id>projects\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                    [
                        'keyName' => 'instance_id',
                        'fieldAccessors' => [
                            'getHeader',
                        ],
                        'matchers' => [
                            '/^projects\/[^\/]+\/(?<instance_id>instances\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                    [
                        'keyName' => 'baz',
                        'fieldAccessors' => [
                            'getOtherHeader',
                        ],
                    ],
                    [
                        'keyName' => 'qux',
                        'fieldAccessors' => [
                            'getOtherHeader',
                        ],
                        'matchers' => [
                            '/^(?<qux>projects\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                ],
            ],
            'EchoErrorDetails' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\EchoErrorDetailsResponse',
            ],
            'Expand' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Showcase\V1beta1\EchoResponse',
            ],
            'FailEchoWithDetails' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\FailEchoWithDetailsResponse',
            ],
            'PagedExpand' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getResponses',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Showcase\V1beta1\PagedExpandResponse',
            ],
            'PagedExpandLegacy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\PagedExpandResponse',
            ],
            'PagedExpandLegacyMapped' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAlphabetized',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Showcase\V1beta1\PagedExpandLegacyMappedResponse',
            ],
        ],
    ],
];
