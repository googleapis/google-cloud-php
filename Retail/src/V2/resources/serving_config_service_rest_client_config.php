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
        'google.cloud.retail.v2.ServingConfigService' => [
            'AddControl' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{serving_config=projects/*/locations/*/catalogs/*/servingConfigs/*}:addControl',
                'body' => '*',
                'placeholders' => [
                    'serving_config' => [
                        'getters' => [
                            'getServingConfig',
                        ],
                    ],
                ],
            ],
            'CreateServingConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/catalogs/*}/servingConfigs',
                'body' => 'serving_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'serving_config_id',
                ],
            ],
            'DeleteServingConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/servingConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetServingConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/servingConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListServingConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/catalogs/*}/servingConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RemoveControl' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{serving_config=projects/*/locations/*/catalogs/*/servingConfigs/*}:removeControl',
                'body' => '*',
                'placeholders' => [
                    'serving_config' => [
                        'getters' => [
                            'getServingConfig',
                        ],
                    ],
                ],
            ],
            'UpdateServingConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{serving_config.name=projects/*/locations/*/catalogs/*/servingConfigs/*}',
                'body' => 'serving_config',
                'placeholders' => [
                    'serving_config.name' => [
                        'getters' => [
                            'getServingConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/branches/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/operations/*}',
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
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*}/operations',
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
        ],
    ],
    'numericEnums' => true,
];
