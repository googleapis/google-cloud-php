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
        'google.cloud.edgenetwork.v1.EdgeNetwork' => [
            'CreateInterconnectAttachment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/zones/*}/interconnectAttachments',
                'body' => 'interconnect_attachment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'interconnect_attachment_id',
                ],
            ],
            'CreateNetwork' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/zones/*}/networks',
                'body' => 'network',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'network_id',
                ],
            ],
            'CreateRouter' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/zones/*}/routers',
                'body' => 'router',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'router_id',
                ],
            ],
            'CreateSubnet' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/zones/*}/subnets',
                'body' => 'subnet',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'subnet_id',
                ],
            ],
            'DeleteInterconnectAttachment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*/interconnectAttachments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteNetwork' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*/networks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRouter' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*/routers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSubnet' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*/subnets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DiagnoseInterconnect' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*/interconnects/*}:diagnose',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DiagnoseNetwork' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*/networks/*}:diagnose',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DiagnoseRouter' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*/routers/*}:diagnose',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInterconnect' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*/interconnects/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInterconnectAttachment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*/interconnectAttachments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNetwork' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*/networks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRouter' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*/routers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSubnet' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*/subnets/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'InitializeZone' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/zones/*}:initialize',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListInterconnectAttachments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/zones/*}/interconnectAttachments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListInterconnects' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/zones/*}/interconnects',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNetworks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/zones/*}/networks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRouters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/zones/*}/routers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSubnets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/zones/*}/subnets',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/zones',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateRouter' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{router.name=projects/*/locations/*/zones/*/routers/*}',
                'body' => 'router',
                'placeholders' => [
                    'router.name' => [
                        'getters' => [
                            'getRouter',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSubnet' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{subnet.name=projects/*/locations/*/zones/*/subnets/*}',
                'body' => 'subnet',
                'placeholders' => [
                    'subnet.name' => [
                        'getters' => [
                            'getSubnet',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*}/locations',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
