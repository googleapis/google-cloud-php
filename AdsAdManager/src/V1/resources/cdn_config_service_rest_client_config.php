<?php
/*
 * Copyright 2026 Google LLC
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
        'google.ads.admanager.v1.CdnConfigService' => [
            'BatchActivateCdnConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/cdnConfigs:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchArchiveCdnConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/cdnConfigs:batchArchive',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateCdnConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/cdnConfigs:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateCdnConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/cdnConfigs:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCdnConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/cdnConfigs',
                'body' => 'cdn_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetCdnConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/cdnConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCdnConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/cdnConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCdnConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{cdn_config.name=networks/*/cdnConfigs/*}',
                'body' => 'cdn_config',
                'placeholders' => [
                    'cdn_config.name' => [
                        'getters' => [
                            'getCdnConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}:cancel',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
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
