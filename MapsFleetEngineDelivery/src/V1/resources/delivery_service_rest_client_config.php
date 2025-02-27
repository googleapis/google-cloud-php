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
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=providers/*}/tasks:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDeliveryVehicle' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=providers/*}/deliveryVehicles',
                'body' => 'delivery_vehicle',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'delivery_vehicle_id',
                ],
            ],
            'CreateTask' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=providers/*}/tasks',
                'body' => 'task',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'task_id',
                ],
            ],
            'DeleteDeliveryVehicle' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=providers/*/deliveryVehicles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTask' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=providers/*/tasks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDeliveryVehicle' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=providers/*/deliveryVehicles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTask' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=providers/*/tasks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTaskTrackingInfo' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=providers/*/taskTrackingInfo/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDeliveryVehicles' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=providers/*}/deliveryVehicles',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTasks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=providers/*}/tasks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateDeliveryVehicle' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{delivery_vehicle.name=providers/*/deliveryVehicles/*}',
                'body' => 'delivery_vehicle',
                'placeholders' => [
                    'delivery_vehicle.name' => [
                        'getters' => [
                            'getDeliveryVehicle',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateTask' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{task.name=providers/*/tasks/*}',
                'body' => 'task',
                'placeholders' => [
                    'task.name' => [
                        'getters' => [
                            'getTask',
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
