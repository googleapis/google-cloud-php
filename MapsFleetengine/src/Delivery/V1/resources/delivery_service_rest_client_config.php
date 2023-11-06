<?php

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
            'SearchTasks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=providers/*}/tasks:search',
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
