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
        'google.cloud.eventarc.publishing.v1.Publisher' => [
            'Publish' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{message_bus=projects/*/locations/*/messageBuses/*}:publish',
                'body' => '*',
                'placeholders' => [
                    'message_bus' => [
                        'getters' => [
                            'getMessageBus',
                        ],
                    ],
                ],
            ],
            'PublishChannelConnectionEvents' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{channel_connection=projects/*/locations/*/channelConnections/*}:publishEvents',
                'body' => '*',
                'placeholders' => [
                    'channel_connection' => [
                        'getters' => [
                            'getChannelConnection',
                        ],
                    ],
                ],
            ],
            'PublishEvents' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{channel=projects/*/locations/*/channels/*}:publishEvents',
                'body' => '*',
                'placeholders' => [
                    'channel' => [
                        'getters' => [
                            'getChannel',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
