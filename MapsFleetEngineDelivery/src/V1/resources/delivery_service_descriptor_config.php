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
        'maps.fleetengine.delivery.v1.DeliveryService' => [
            'BatchCreateTasks' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\Delivery\V1\BatchCreateTasksResponse',
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
            'CreateDeliveryVehicle' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\Delivery\V1\DeliveryVehicle',
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
            'CreateTask' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\Delivery\V1\Task',
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
            'GetDeliveryVehicle' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\Delivery\V1\DeliveryVehicle',
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
            'GetTask' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\Delivery\V1\Task',
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
            'GetTaskTrackingInfo' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\Delivery\V1\TaskTrackingInfo',
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
            'ListDeliveryVehicles' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDeliveryVehicles',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Maps\FleetEngine\Delivery\V1\ListDeliveryVehiclesResponse',
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
            'ListTasks' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTasks',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Maps\FleetEngine\Delivery\V1\ListTasksResponse',
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
            'UpdateDeliveryVehicle' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\Delivery\V1\DeliveryVehicle',
                'headerParams' => [
                    [
                        'keyName' => 'provider_id',
                        'fieldAccessors' => [
                            'getDeliveryVehicle',
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<provider_id>providers\/[^\/]+)$/',
                        ],
                    ],
                ],
            ],
            'UpdateTask' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Maps\FleetEngine\Delivery\V1\Task',
                'headerParams' => [
                    [
                        'keyName' => 'provider_id',
                        'fieldAccessors' => [
                            'getTask',
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<provider_id>providers\/[^\/]+)$/',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'deliveryVehicle' => 'providers/{provider}/deliveryVehicles/{vehicle}',
                'provider' => 'providers/{provider}',
                'task' => 'providers/{provider}/tasks/{task}',
                'taskTrackingInfo' => 'providers/{provider}/taskTrackingInfo/{tracking}',
            ],
        ],
    ],
];
