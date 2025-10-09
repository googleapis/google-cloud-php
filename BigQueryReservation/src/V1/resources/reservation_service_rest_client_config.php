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
            'CreateReservationGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/reservationGroups',
                'body' => 'reservation_group',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'reservation_group_id',
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
            'DeleteReservationGroup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/reservationGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FailoverReservation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/reservations/*}:failoverReservation',
                'body' => '*',
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
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/reservations/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/reservations/*/assignments/*}:getIamPolicy',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
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
            'GetReservationGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/reservationGroups/*}',
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
            'ListReservationGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/reservationGroups',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/reservations/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/reservations/*/assignments/*}:setIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
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
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/reservations/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/reservations/*/assignments/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
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
    'numericEnums' => true,
];
