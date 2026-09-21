<?php
/*
 * Copyright 2026 Google LLC
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
        'google.ads.admanager.v1.OrderService' => [
            'BatchApproveAndOverbookOrders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchApproveAndOverbook',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchApproveOrders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchApprove',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchApproveOrdersWithoutReservation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchApproveWithoutReservation',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchArchiveOrders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchArchive',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateOrders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeleteOrders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDisapproveOrders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchDisapprove',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDisapproveOrdersWithoutReservationChanges' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchDisapproveWithoutReservationChanges',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchPauseOrders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchPause',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchResumeAndOverbookOrders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchResumeAndOverbook',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchResumeOrders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchResume',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRetractOrders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchRetract',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRetractOrdersWithoutReservationChanges' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchRetractWithoutReservationChanges',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchSubmitOrdersForApproval' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchSubmitForApproval',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchSubmitOrdersForApprovalAndOverbook' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchSubmitForApprovalAndOverbook',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchSubmitOrdersForApprovalWithoutReservationChanges' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchSubmitForApprovalWithoutReservationChanges',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUnarchiveOrders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchUnarchive',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateOrders' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/orders:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetOrder' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/orders/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOrders' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/orders',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}:cancel',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}',
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
