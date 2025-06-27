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
        'google.ads.admanager.v1.AdBreakService' => [
            'CreateAdBreak' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*/liveStreamEventsByAssetKey/*}/adBreaks',
                'body' => 'ad_break',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=networks/*/liveStreamEventsByCustomAssetKey/*}/adBreaks',
                        'body' => 'ad_break',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=networks/*/liveStreamEvents/*}/adBreaks',
                        'body' => 'ad_break',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAdBreak' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=networks/*/liveStreamEventsByAssetKey/*/adBreaks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAdBreak' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/liveStreamEventsByAssetKey/*/adBreaks/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=networks/*/liveStreamEventsByCustomAssetKey/*/adBreaks/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=networks/*/liveStreamEvents/*/adBreaks/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAdBreaks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*/liveStreamEventsByAssetKey/*}/adBreaks',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=networks/*/liveStreamEventsByCustomAssetKey/*}/adBreaks',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=networks/*/liveStreamEvents/*}/adBreaks',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAdBreak' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{ad_break.name=networks/*/liveStreamEventsByAssetKey/*/adBreaks/*}',
                'body' => 'ad_break',
                'placeholders' => [
                    'ad_break.name' => [
                        'getters' => [
                            'getAdBreak',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
