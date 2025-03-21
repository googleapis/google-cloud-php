<?php
/*
 * Copyright 2025 Google LLC
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
        'google.cloud.networkconnectivity.v1.CrossNetworkAutomationService' => [
            'CreateServiceConnectionMap' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/serviceConnectionMaps',
                'body' => 'service_connection_map',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateServiceConnectionPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/serviceConnectionPolicies',
                'body' => 'service_connection_policy',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateServiceConnectionToken' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/serviceConnectionTokens',
                'body' => 'service_connection_token',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteServiceClass' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/serviceClasses/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteServiceConnectionMap' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/serviceConnectionMaps/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteServiceConnectionPolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/serviceConnectionPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteServiceConnectionToken' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/serviceConnectionTokens/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetServiceClass' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/serviceClasses/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetServiceConnectionMap' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/serviceConnectionMaps/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetServiceConnectionPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/serviceConnectionPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetServiceConnectionToken' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/serviceConnectionTokens/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListServiceClasses' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/serviceClasses',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListServiceConnectionMaps' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/serviceConnectionMaps',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListServiceConnectionPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/serviceConnectionPolicies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListServiceConnectionTokens' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/serviceConnectionTokens',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateServiceClass' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{service_class.name=projects/*/locations/*/serviceClasses/*}',
                'body' => 'service_class',
                'placeholders' => [
                    'service_class.name' => [
                        'getters' => [
                            'getServiceClass',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateServiceConnectionMap' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{service_connection_map.name=projects/*/locations/*/serviceConnectionMaps/*}',
                'body' => 'service_connection_map',
                'placeholders' => [
                    'service_connection_map.name' => [
                        'getters' => [
                            'getServiceConnectionMap',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateServiceConnectionPolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{service_connection_policy.name=projects/*/locations/*/serviceConnectionPolicies/*}',
                'body' => 'service_connection_policy',
                'placeholders' => [
                    'service_connection_policy.name' => [
                        'getters' => [
                            'getServiceConnectionPolicy',
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
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serviceConnectionMaps/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serviceConnectionPolicies/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serviceClasses/*}:getIamPolicy',
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
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serviceConnectionMaps/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serviceConnectionPolicies/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serviceClasses/*}:setIamPolicy',
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
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serviceConnectionMaps/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serviceConnectionPolicies/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serviceClasses/*}:testIamPermissions',
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
