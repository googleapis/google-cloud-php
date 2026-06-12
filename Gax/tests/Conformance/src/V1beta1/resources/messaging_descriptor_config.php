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
        'google.showcase.v1beta1.Messaging' => [
            'SearchBlurbs' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Showcase\V1beta1\SearchBlurbsResponse',
                    'metadataReturnType' => '\Google\Showcase\V1beta1\SearchBlurbsMetadata',
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
            'Connect' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Showcase\V1beta1\StreamBlurbsResponse',
            ],
            'CreateBlurb' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\Blurb',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateRoom' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\Room',
            ],
            'DeleteBlurb' => [
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
            'DeleteRoom' => [
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
            'GetBlurb' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\Blurb',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRoom' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\Room',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBlurbs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getBlurbs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Showcase\V1beta1\ListBlurbsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRooms' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getRooms',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Showcase\V1beta1\ListRoomsResponse',
            ],
            'SendBlurbs' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ClientStreaming',
                ],
                'callType' => \Google\ApiCore\Call::CLIENT_STREAMING_CALL,
                'responseType' => 'Google\Showcase\V1beta1\SendBlurbsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'StreamBlurbs' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Showcase\V1beta1\StreamBlurbsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateBlurb' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\Blurb',
                'headerParams' => [
                    [
                        'keyName' => 'blurb.name',
                        'fieldAccessors' => [
                            'getBlurb',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRoom' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\Room',
                'headerParams' => [
                    [
                        'keyName' => 'room.name',
                        'fieldAccessors' => [
                            'getRoom',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'blurb' => 'users/{user}/blurbs/{blurb}',
                'room' => 'rooms/{room}',
                'roomBlurb' => 'rooms/{room}/blurbs/{blurb}',
                'roomLegacyRoom' => 'rooms/{room}/legacy_room/{legacy_room}',
                'roomLegacyRoomBlurb' => 'rooms/{room}/legacy_room/{legacy_room}/blurbs/{blurb}',
                'user' => 'users/{user}',
                'userBlurb' => 'users/{user}/blurbs/{blurb}',
                'userBlurbLegacyUser' => 'users/{user}/blurbs/{blurb}/legacy/{legacy_user}',
            ],
        ],
    ],
];
