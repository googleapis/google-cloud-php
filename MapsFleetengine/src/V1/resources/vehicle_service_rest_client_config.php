<?php

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
            'SearchFuzzedVehicles' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=providers/*}/vehicles:searchFuzzed',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
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
            'UpdateVehicleLocation' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{name=providers/*/vehicles/*}:updateLocation',
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
