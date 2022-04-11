<?php

return [
    'interfaces' => [
        'google.cloud.bigquery.reservation.v1.ReservationService' => [
            'CreateAssignment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/reservations/*}/assignments',
                'body' => 'assignment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCapacityCommitment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/capacityCommitments',
                'body' => 'capacity_commitment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateReservation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/reservations',
                'body' => 'reservation',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAssignment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/reservations/*/assignments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCapacityCommitment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/capacityCommitments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteReservation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/reservations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBiReservation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/biReservation}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCapacityCommitment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/capacityCommitments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetReservation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/reservations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAssignments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/reservations/*}/assignments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCapacityCommitments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/capacityCommitments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListReservations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/reservations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'MergeCapacityCommitments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/capacityCommitments:merge',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'MoveAssignment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/reservations/*/assignments/*}:move',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchAllAssignments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:searchAllAssignments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchAssignments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:searchAssignments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SplitCapacityCommitment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/capacityCommitments/*}:split',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAssignment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{assignment.name=projects/*/locations/*/reservations/*/assignments/*}',
                'body' => 'assignment',
                'placeholders' => [
                    'assignment.name' => [
                        'getters' => [
                            'getAssignment',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateBiReservation' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{bi_reservation.name=projects/*/locations/*/biReservation}',
                'body' => 'bi_reservation',
                'placeholders' => [
                    'bi_reservation.name' => [
                        'getters' => [
                            'getBiReservation',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCapacityCommitment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{capacity_commitment.name=projects/*/locations/*/capacityCommitments/*}',
                'body' => 'capacity_commitment',
                'placeholders' => [
                    'capacity_commitment.name' => [
                        'getters' => [
                            'getCapacityCommitment',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateReservation' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{reservation.name=projects/*/locations/*/reservations/*}',
                'body' => 'reservation',
                'placeholders' => [
                    'reservation.name' => [
                        'getters' => [
                            'getReservation',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
