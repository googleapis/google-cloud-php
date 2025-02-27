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
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\V1\Vehicle',
                'headerParams' => [
                    [
                        'keyName' => 'provider_id',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                        'matchers' => [
                            '/^(?<provider_id>providers\/[^\/]+)$/',
                        ],
                    ],
                ],
            ],
            'DeleteVehicle' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'provider_id',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<provider_id>providers\/[^\/]+)$/',
                        ],
                    ],
                ],
            ],
            'GetVehicle' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\V1\Vehicle',
                'headerParams' => [
                    [
                        'keyName' => 'provider_id',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<provider_id>providers\/[^\/]+)$/',
                        ],
                    ],
                ],
            ],
            'ListVehicles' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getVehicles',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Maps\FleetEngine\V1\ListVehiclesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'provider_id',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                        'matchers' => [
                            '/^(?<provider_id>providers\/[^\/]+)$/',
                        ],
                    ],
                ],
            ],
            'SearchVehicles' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\V1\SearchVehiclesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'provider_id',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                        'matchers' => [
                            '/^(?<provider_id>providers\/[^\/]+)$/',
                        ],
                    ],
                ],
            ],
            'UpdateVehicle' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\V1\Vehicle',
                'headerParams' => [
                    [
                        'keyName' => 'provider_id',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<provider_id>providers\/[^\/]+)$/',
                        ],
                    ],
                ],
            ],
            'UpdateVehicleAttributes' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\V1\UpdateVehicleAttributesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'provider_id',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<provider_id>providers\/[^\/]+)$/',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'vehicle' => 'providers/{provider}/vehicles/{vehicle}',
            ],
        ],
    ],
];
