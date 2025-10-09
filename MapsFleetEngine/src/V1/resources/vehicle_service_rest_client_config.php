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
        'maps.fleetengine.v1.VehicleService' => [
            'CreateVehicle' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=providers/*}/vehicles',
                'body' => 'vehicle',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'vehicle_id',
                ],
            ],
            'DeleteVehicle' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=providers/*/vehicles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVehicle' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=providers/*/vehicles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListVehicles' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=providers/*}/vehicles',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'vehicle_type_categories',
                ],
            ],
            'SearchVehicles' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=providers/*}/vehicles:search',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateVehicle' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{name=providers/*/vehicles/*}',
                'body' => 'vehicle',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateVehicleAttributes' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=providers/*/vehicles/*}:updateAttributes',
                'body' => '*',
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
