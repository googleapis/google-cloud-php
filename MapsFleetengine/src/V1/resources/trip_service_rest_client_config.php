<?php

return [
    'interfaces' => [
        'maps.fleetengine.v1.TripService' => [
            'CreateTrip' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=providers/*}/trips',
                'body' => 'trip',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'trip_id',
                ],
            ],
            'GetTrip' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=providers/*/trips/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ReportBillableTrip' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=providers/*/billableTrips/*}:report',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchTrips' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=providers/*}/trips:search',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateTrip' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{name=providers/*/trips/*}',
                'body' => 'trip',
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
        ],
    ],
    'numericEnums' => true,
];
