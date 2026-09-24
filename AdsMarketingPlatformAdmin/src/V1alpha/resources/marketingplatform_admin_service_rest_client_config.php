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
        'google.marketingplatform.admin.v1alpha.MarketingplatformAdminService' => [
            'CreateAdminAccessBinding' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=organizations/*}/adminAccessBindings',
                'body' => 'admin_access_binding',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAnalyticsAccountLink' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=organizations/*}/analyticsAccountLinks',
                'body' => 'analytics_account_link',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateUserGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=organizations/*}/userGroups',
                'body' => 'user_group',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateUserGroupMember' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=organizations/*/userGroups/*}/members',
                'body' => 'user_group_member',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAnalyticsAccountLink' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=organizations/*/analyticsAccountLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUserGroup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=organizations/*/userGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUserGroupMember' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=organizations/*/userGroups/*/members/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FindSalesPartnerManagedClients' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{organization=organizations/*}:findSalesPartnerManagedClients',
                'body' => '*',
                'placeholders' => [
                    'organization' => [
                        'getters' => [
                            'getOrganization',
                        ],
                    ],
                ],
            ],
            'GetAdminAccessBinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=organizations/*/adminAccessBindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOrganization' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=organizations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUserGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=organizations/*/userGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUserGroupMember' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=organizations/*/userGroups/*/members/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAdminAccessBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=organizations/*}/adminAccessBindings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAnalyticsAccountLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=organizations/*}/analyticsAccountLinks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOrganizations' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/organizations',
            ],
            'ListUserGroupMembers' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=organizations/*/userGroups/*}/members',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListUserGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=organizations/*}/userGroups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ReportPropertyUsage' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{organization=organizations/*}:reportPropertyUsage',
                'body' => '*',
                'placeholders' => [
                    'organization' => [
                        'getters' => [
                            'getOrganization',
                        ],
                    ],
                ],
            ],
            'SetPropertyServiceLevel' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{analytics_account_link=organizations/*/analyticsAccountLinks/*}:setPropertyServiceLevel',
                'body' => '*',
                'placeholders' => [
                    'analytics_account_link' => [
                        'getters' => [
                            'getAnalyticsAccountLink',
                        ],
                    ],
                ],
            ],
            'UpdateAdminAccessBinding' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{admin_access_binding.name=organizations/*/adminAccessBindings/*}',
                'body' => 'admin_access_binding',
                'placeholders' => [
                    'admin_access_binding.name' => [
                        'getters' => [
                            'getAdminAccessBinding',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateUserGroup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{user_group.name=organizations/*/userGroups/*}',
                'body' => 'user_group',
                'placeholders' => [
                    'user_group.name' => [
                        'getters' => [
                            'getUserGroup',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateUserGroupMember' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{user_group_member.name=organizations/*/userGroups/*/members/*}',
                'body' => 'user_group_member',
                'placeholders' => [
                    'user_group_member.name' => [
                        'getters' => [
                            'getUserGroupMember',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
