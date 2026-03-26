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
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*}',
                    ],
                ],
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
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.networksecurity.v1.Mirroring' => [
            'CreateMirroringDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/mirroringDeployments',
                'body' => 'mirroring_deployment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'mirroring_deployment_id',
                ],
            ],
            'CreateMirroringDeploymentGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/mirroringDeploymentGroups',
                'body' => 'mirroring_deployment_group',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'mirroring_deployment_group_id',
                ],
            ],
            'CreateMirroringEndpointGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/mirroringEndpointGroups',
                'body' => 'mirroring_endpoint_group',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'mirroring_endpoint_group_id',
                ],
            ],
            'CreateMirroringEndpointGroupAssociation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/mirroringEndpointGroupAssociations',
                'body' => 'mirroring_endpoint_group_association',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteMirroringDeployment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/mirroringDeployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMirroringDeploymentGroup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/mirroringDeploymentGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMirroringEndpointGroup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/mirroringEndpointGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMirroringEndpointGroupAssociation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/mirroringEndpointGroupAssociations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMirroringDeployment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/mirroringDeployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMirroringDeploymentGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/mirroringDeploymentGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMirroringEndpointGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/mirroringEndpointGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMirroringEndpointGroupAssociation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/mirroringEndpointGroupAssociations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListMirroringDeploymentGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/mirroringDeploymentGroups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMirroringDeployments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/mirroringDeployments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMirroringEndpointGroupAssociations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/mirroringEndpointGroupAssociations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMirroringEndpointGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/mirroringEndpointGroups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateMirroringDeployment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{mirroring_deployment.name=projects/*/locations/*/mirroringDeployments/*}',
                'body' => 'mirroring_deployment',
                'placeholders' => [
                    'mirroring_deployment.name' => [
                        'getters' => [
                            'getMirroringDeployment',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateMirroringDeploymentGroup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{mirroring_deployment_group.name=projects/*/locations/*/mirroringDeploymentGroups/*}',
                'body' => 'mirroring_deployment_group',
                'placeholders' => [
                    'mirroring_deployment_group.name' => [
                        'getters' => [
                            'getMirroringDeploymentGroup',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateMirroringEndpointGroup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{mirroring_endpoint_group.name=projects/*/locations/*/mirroringEndpointGroups/*}',
                'body' => 'mirroring_endpoint_group',
                'placeholders' => [
                    'mirroring_endpoint_group.name' => [
                        'getters' => [
                            'getMirroringEndpointGroup',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateMirroringEndpointGroupAssociation' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{mirroring_endpoint_group_association.name=projects/*/locations/*/mirroringEndpointGroupAssociations/*}',
                'body' => 'mirroring_endpoint_group_association',
                'placeholders' => [
                    'mirroring_endpoint_group_association.name' => [
                        'getters' => [
                            'getMirroringEndpointGroupAssociation',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/addressGroups/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/authorizationPolicies/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=organizations/*/locations/*/addressGroups/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serverTlsPolicies/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/clientTlsPolicies/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/authzPolicies/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/addressGroups/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/authorizationPolicies/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=organizations/*/locations/*/addressGroups/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serverTlsPolicies/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/clientTlsPolicies/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/authzPolicies/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/addressGroups/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/authorizationPolicies/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=organizations/*/locations/*/addressGroups/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/serverTlsPolicies/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/clientTlsPolicies/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/authzPolicies/*}:testIamPermissions',
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
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/operations/*}:cancel',
                        'body' => '*',
                    ],
                ],
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
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/operations/*}',
                    ],
                ],
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
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/operations/*}',
                    ],
                ],
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
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*}/operations',
                    ],
                ],
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
