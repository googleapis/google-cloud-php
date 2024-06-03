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
        'google.cloud.resourcesettings.v1.ResourceSettingsService' => [
            'GetSetting' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/settings/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/settings/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/settings/*}',
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
            'ListSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*}/settings',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*}/settings',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*}/settings',
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
            'UpdateSetting' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{setting.name=organizations/*/settings/*}',
                'body' => 'setting',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{setting.name=folders/*/settings/*}',
                        'body' => 'setting',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{setting.name=projects/*/settings/*}',
                        'body' => 'setting',
                    ],
                ],
                'placeholders' => [
                    'setting.name' => [
                        'getters' => [
                            'getSetting',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
