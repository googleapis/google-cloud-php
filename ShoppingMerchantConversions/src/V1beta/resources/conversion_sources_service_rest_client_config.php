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
        'google.shopping.merchant.conversions.v1beta.ConversionSourcesService' => [
            'CreateConversionSource' => [
                'method' => 'post',
                'uriTemplate' => '/conversions/v1beta/{parent=accounts/*}/conversionSources',
                'body' => 'conversion_source',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteConversionSource' => [
                'method' => 'delete',
                'uriTemplate' => '/conversions/v1beta/{name=accounts/*/conversionSources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConversionSource' => [
                'method' => 'get',
                'uriTemplate' => '/conversions/v1beta/{name=accounts/*/conversionSources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListConversionSources' => [
                'method' => 'get',
                'uriTemplate' => '/conversions/v1beta/{parent=accounts/*}/conversionSources',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UndeleteConversionSource' => [
                'method' => 'post',
                'uriTemplate' => '/conversions/v1beta/{name=accounts/*/conversionSources/*}:undelete',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateConversionSource' => [
                'method' => 'patch',
                'uriTemplate' => '/conversions/v1beta/{conversion_source.name=accounts/*/conversionSources/*}',
                'body' => 'conversion_source',
                'placeholders' => [
                    'conversion_source.name' => [
                        'getters' => [
                            'getConversionSource',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
