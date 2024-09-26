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
        'google.cloud.gdchardwaremanagement.v1alpha.GDCHardwareManagement' => [
            'CreateComment' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*/orders/*}/comments',
                'body' => 'comment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateHardware' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*}/hardware',
                'body' => 'hardware',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateHardwareGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*/orders/*}/hardwareGroups',
                'body' => 'hardware_group',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateOrder' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*}/orders',
                'body' => 'order',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSite' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*}/sites',
                'body' => 'site',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateZone' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*}/zones',
                'body' => 'zone',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteHardware' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/hardware/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteHardwareGroup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/orders/*/hardwareGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOrder' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/orders/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteZone' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/zones/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetChangeLogEntry' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/orders/*/changeLogEntries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetComment' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/orders/*/comments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetHardware' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/hardware/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetHardwareGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/orders/*/hardwareGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOrder' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/orders/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSite' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/sites/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSku' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/skus/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetZone' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/zones/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListChangeLogEntries' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*/orders/*}/changeLogEntries',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListComments' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*/orders/*}/comments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListHardware' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*}/hardware',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListHardwareGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*/orders/*}/hardwareGroups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOrders' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*}/orders',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSites' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*}/sites',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSkus' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*}/skus',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListZones' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=projects/*/locations/*}/zones',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RecordActionOnComment' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/orders/*/comments/*}:recordAction',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SignalZoneState' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/zones/*}:signal',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SubmitOrder' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/orders/*}:submit',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateHardware' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{hardware.name=projects/*/locations/*/hardware/*}',
                'body' => 'hardware',
                'placeholders' => [
                    'hardware.name' => [
                        'getters' => [
                            'getHardware',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateHardwareGroup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{hardware_group.name=projects/*/locations/*/orders/*/hardwareGroups/*}',
                'body' => 'hardware_group',
                'placeholders' => [
                    'hardware_group.name' => [
                        'getters' => [
                            'getHardwareGroup',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateOrder' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{order.name=projects/*/locations/*/orders/*}',
                'body' => 'order',
                'placeholders' => [
                    'order.name' => [
                        'getters' => [
                            'getOrder',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSite' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{site.name=projects/*/locations/*/sites/*}',
                'body' => 'site',
                'placeholders' => [
                    'site.name' => [
                        'getters' => [
                            'getSite',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateZone' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{zone.name=projects/*/locations/*/zones/*}',
                'body' => 'zone',
                'placeholders' => [
                    'zone.name' => [
                        'getters' => [
                            'getZone',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=projects/*/locations/*}/operations',
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
