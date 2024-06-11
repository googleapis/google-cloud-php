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
        'google.cloud.networkservices.v1.NetworkServices' => [
            'CreateEndpointPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/endpointPolicies',
                'body' => 'endpoint_policy',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'endpoint_policy_id',
                ],
            ],
            'CreateGateway' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/gateways',
                'body' => 'gateway',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'gateway_id',
                ],
            ],
            'CreateGrpcRoute' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/grpcRoutes',
                'body' => 'grpc_route',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'grpc_route_id',
                ],
            ],
            'CreateHttpRoute' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/httpRoutes',
                'body' => 'http_route',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'http_route_id',
                ],
            ],
            'CreateMesh' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/meshes',
                'body' => 'mesh',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'mesh_id',
                ],
            ],
            'CreateServiceBinding' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/serviceBindings',
                'body' => 'service_binding',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'service_binding_id',
                ],
            ],
            'CreateTcpRoute' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/tcpRoutes',
                'body' => 'tcp_route',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'tcp_route_id',
                ],
            ],
            'CreateTlsRoute' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/tlsRoutes',
                'body' => 'tls_route',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'tls_route_id',
                ],
            ],
            'DeleteEndpointPolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/endpointPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGateway' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/gateways/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGrpcRoute' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/grpcRoutes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteHttpRoute' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/httpRoutes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMesh' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/meshes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteServiceBinding' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/serviceBindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTcpRoute' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tcpRoutes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTlsRoute' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tlsRoutes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEndpointPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/endpointPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGateway' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/gateways/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGrpcRoute' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/grpcRoutes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetHttpRoute' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/httpRoutes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMesh' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/meshes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetServiceBinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/serviceBindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTcpRoute' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tcpRoutes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTlsRoute' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tlsRoutes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListEndpointPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/endpointPolicies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListGateways' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/gateways',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListGrpcRoutes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/grpcRoutes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListHttpRoutes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/httpRoutes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMeshes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/meshes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListServiceBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/serviceBindings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTcpRoutes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/tcpRoutes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTlsRoutes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/tlsRoutes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateEndpointPolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{endpoint_policy.name=projects/*/locations/*/endpointPolicies/*}',
                'body' => 'endpoint_policy',
                'placeholders' => [
                    'endpoint_policy.name' => [
                        'getters' => [
                            'getEndpointPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGateway' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{gateway.name=projects/*/locations/*/gateways/*}',
                'body' => 'gateway',
                'placeholders' => [
                    'gateway.name' => [
                        'getters' => [
                            'getGateway',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGrpcRoute' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{grpc_route.name=projects/*/locations/*/grpcRoutes/*}',
                'body' => 'grpc_route',
                'placeholders' => [
                    'grpc_route.name' => [
                        'getters' => [
                            'getGrpcRoute',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateHttpRoute' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{http_route.name=projects/*/locations/*/httpRoutes/*}',
                'body' => 'http_route',
                'placeholders' => [
                    'http_route.name' => [
                        'getters' => [
                            'getHttpRoute',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateMesh' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{mesh.name=projects/*/locations/*/meshes/*}',
                'body' => 'mesh',
                'placeholders' => [
                    'mesh.name' => [
                        'getters' => [
                            'getMesh',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTcpRoute' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{tcp_route.name=projects/*/locations/*/tcpRoutes/*}',
                'body' => 'tcp_route',
                'placeholders' => [
                    'tcp_route.name' => [
                        'getters' => [
                            'getTcpRoute',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTlsRoute' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{tls_route.name=projects/*/locations/*/tlsRoutes/*}',
                'body' => 'tls_route',
                'placeholders' => [
                    'tls_route.name' => [
                        'getters' => [
                            'getTlsRoute',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/edgeCacheKeysets/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/edgeCacheOrigins/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/edgeCacheServices/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/endpointPolicies/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serviceBindings/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/meshes/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/gateways/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/edgeCacheKeysets/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/edgeCacheOrigins/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/edgeCacheServices/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/endpointPolicies/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serviceBindings/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/meshes/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/gateways/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/edgeCacheKeysets/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/edgeCacheOrigins/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/edgeCacheServices/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/endpointPolicies/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serviceBindings/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/meshes/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/gateways/*}:testIamPermissions',
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
