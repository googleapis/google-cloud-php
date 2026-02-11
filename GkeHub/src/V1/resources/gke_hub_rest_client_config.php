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
        'google.cloud.gkehub.v1.GkeHub' => [
            'CreateFeature' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/features',
                'body' => 'resource',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateFleet' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/fleets',
                'body' => 'fleet',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateMembership' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/memberships',
                'body' => 'resource',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'membership_id',
                ],
            ],
            'CreateMembershipBinding' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/memberships/*}/bindings',
                'body' => 'membership_binding',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'membership_binding_id',
                ],
            ],
            'CreateMembershipRBACRoleBinding' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/memberships/*}/rbacrolebindings',
                'body' => 'rbacrolebinding',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'rbacrolebinding_id',
                ],
            ],
            'CreateScope' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/scopes',
                'body' => 'scope',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'scope_id',
                ],
            ],
            'CreateScopeNamespace' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/scopes/*}/namespaces',
                'body' => 'scope_namespace',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'scope_namespace_id',
                ],
            ],
            'CreateScopeRBACRoleBinding' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/scopes/*}/rbacrolebindings',
                'body' => 'rbacrolebinding',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'rbacrolebinding_id',
                ],
            ],
            'DeleteFeature' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/features/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteFleet' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/fleets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMembership' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/memberships/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMembershipBinding' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/memberships/*/bindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMembershipRBACRoleBinding' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/memberships/*/rbacrolebindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteScope' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/scopes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteScopeNamespace' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/scopes/*/namespaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteScopeRBACRoleBinding' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/scopes/*/rbacrolebindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateConnectManifest' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/memberships/*}:generateConnectManifest',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateMembershipRBACRoleBindingYAML' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/memberships/*}/rbacrolebindings:generateMembershipRBACRoleBindingYAML',
                'body' => 'rbacrolebinding',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetFeature' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/features/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFleet' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/fleets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMembership' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/memberships/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMembershipBinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/memberships/*/bindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMembershipRBACRoleBinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/memberships/*/rbacrolebindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetScope' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/scopes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetScopeNamespace' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/scopes/*/namespaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetScopeRBACRoleBinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/scopes/*/rbacrolebindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBoundMemberships' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{scope_name=projects/*/locations/*/scopes/*}:listMemberships',
                'placeholders' => [
                    'scope_name' => [
                        'getters' => [
                            'getScopeName',
                        ],
                    ],
                ],
            ],
            'ListFeatures' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/features',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListFleets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/fleets',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/fleets',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMembershipBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/memberships/*}/bindings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMembershipRBACRoleBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/memberships/*}/rbacrolebindings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMemberships' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/memberships',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPermittedScopes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/scopes:listPermitted',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListScopeNamespaces' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/scopes/*}/namespaces',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListScopeRBACRoleBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/scopes/*}/rbacrolebindings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListScopes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/scopes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateFeature' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/features/*}',
                'body' => 'resource',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateFleet' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{fleet.name=projects/*/locations/*/fleets/*}',
                'body' => 'fleet',
                'placeholders' => [
                    'fleet.name' => [
                        'getters' => [
                            'getFleet',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateMembership' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/memberships/*}',
                'body' => 'resource',
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
            'UpdateMembershipBinding' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{membership_binding.name=projects/*/locations/*/memberships/*/bindings/*}',
                'body' => 'membership_binding',
                'placeholders' => [
                    'membership_binding.name' => [
                        'getters' => [
                            'getMembershipBinding',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateMembershipRBACRoleBinding' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{rbacrolebinding.name=projects/*/locations/*/memberships/*/rbacrolebindings/*}',
                'body' => 'rbacrolebinding',
                'placeholders' => [
                    'rbacrolebinding.name' => [
                        'getters' => [
                            'getRbacrolebinding',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateScope' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{scope.name=projects/*/locations/*/scopes/*}',
                'body' => 'scope',
                'placeholders' => [
                    'scope.name' => [
                        'getters' => [
                            'getScope',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateScopeNamespace' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{scope_namespace.name=projects/*/locations/*/scopes/*/namespaces/*}',
                'body' => 'scope_namespace',
                'placeholders' => [
                    'scope_namespace.name' => [
                        'getters' => [
                            'getScopeNamespace',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateScopeRBACRoleBinding' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{rbacrolebinding.name=projects/*/locations/*/scopes/*/rbacrolebindings/*}',
                'body' => 'rbacrolebinding',
                'placeholders' => [
                    'rbacrolebinding.name' => [
                        'getters' => [
                            'getRbacrolebinding',
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
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/memberships/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/features/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/memberships/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/features/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/memberships/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/features/*}:testIamPermissions',
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
