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
        'maps.fleetengine.v1.TripService' => [
            'CreateTrip' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\V1\Trip',
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
            'DeleteTrip' => [
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
            'GetTrip' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\V1\Trip',
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
            'ReportBillableTrip' => [
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
            'SearchTrips' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTrips',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Maps\FleetEngine\V1\SearchTripsResponse',
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
            'UpdateTrip' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\V1\Trip',
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
                'trip' => 'providers/{provider}/trips/{trip}',
            ],
        ],
    ],
];
