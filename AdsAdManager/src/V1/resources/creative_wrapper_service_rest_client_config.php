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
        'google.ads.admanager.v1.CreativeWrapperService' => [
            'BatchActivateCreativeWrappers' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/creativeWrappers:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateCreativeWrappers' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/creativeWrappers:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivateCreativeWrappers' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/creativeWrappers:batchDeactivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateCreativeWrappers' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/creativeWrappers:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCreativeWrapper' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/creativeWrappers',
                'body' => 'creative_wrapper',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetCreativeWrapper' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/creativeWrappers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCreativeWrappers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/creativeWrappers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCreativeWrapper' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{creative_wrapper.name=networks/*/creativeWrappers/*}',
                'body' => 'creative_wrapper',
                'placeholders' => [
                    'creative_wrapper.name' => [
                        'getters' => [
                            'getCreativeWrapper',
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
