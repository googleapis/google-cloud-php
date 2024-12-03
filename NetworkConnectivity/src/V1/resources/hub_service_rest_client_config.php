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
        'google.cloud.networkconnectivity.v1.HubService' => [
            'AcceptHubSpoke' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/hubs/*}:acceptSpoke',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateHub' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/global}/hubs',
                'body' => 'hub',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'hub_id',
                ],
            ],
            'CreateSpoke' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/spokes',
                'body' => 'spoke',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'spoke_id',
                ],
            ],
            'DeleteHub' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/hubs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSpoke' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spokes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/hubs/*/groups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetHub' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/hubs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRoute' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/hubs/*/routeTables/*/routes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRouteTable' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/hubs/*/routeTables/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSpoke' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spokes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/global/hubs/*}/groups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListHubSpokes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/hubs/*}:listSpokes',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListHubs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/global}/hubs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRouteTables' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/global/hubs/*}/routeTables',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRoutes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/global/hubs/*/routeTables/*}/routes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSpokes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/spokes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'QueryHubStatus' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/hubs/*}:queryStatus',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RejectHubSpoke' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/global/hubs/*}:rejectSpoke',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGroup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{group.name=projects/*/locations/global/hubs/*/groups/*}',
                'body' => 'group',
                'placeholders' => [
                    'group.name' => [
                        'getters' => [
                            'getGroup',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateHub' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{hub.name=projects/*/locations/global/hubs/*}',
                'body' => 'hub',
                'placeholders' => [
                    'hub.name' => [
                        'getters' => [
                            'getHub',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSpoke' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{spoke.name=projects/*/locations/*/spokes/*}',
                'body' => 'spoke',
                'placeholders' => [
                    'spoke.name' => [
                        'getters' => [
                            'getSpoke',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/global/hubs/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/global/hubs/*/groups/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/spokes/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/global/policyBasedRoutes/*}:getIamPolicy',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/global/hubs/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/global/hubs/*/groups/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/spokes/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/global/policyBasedRoutes/*}:setIamPolicy',
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
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/global/hubs/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/global/hubs/*/groups/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/spokes/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/global/policyBasedRoutes/*}:testIamPermissions',
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
