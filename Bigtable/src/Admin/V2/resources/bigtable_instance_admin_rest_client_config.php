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
        'google.bigtable.admin.v2.BigtableInstanceAdmin' => [
            'CreateAppProfile' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/appProfiles',
                'body' => 'app_profile',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'app_profile_id',
                ],
            ],
            'CreateCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/clusters',
                'body' => 'cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'cluster_id',
                ],
            ],
            'CreateInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/instances',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateLogicalView' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/logicalViews',
                'body' => 'logical_view',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'logical_view_id',
                ],
            ],
            'CreateMaterializedView' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/materializedViews',
                'body' => 'materialized_view',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'materialized_view_id',
                ],
            ],
            'DeleteAppProfile' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/appProfiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'ignore_warnings',
                ],
            ],
            'DeleteCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/clusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteInstance' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteLogicalView' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/logicalViews/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMaterializedView' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/materializedViews/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAppProfile' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/appProfiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/clusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=projects/*/instances/*}:getIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{resource=projects/*/instances/*/materializedViews/*}:getIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{resource=projects/*/instances/*/logicalViews/*}:getIamPolicy',
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
            'GetInstance' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLogicalView' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/logicalViews/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMaterializedView' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/materializedViews/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAppProfiles' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/appProfiles',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/clusters',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListHotTablets' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*/clusters/*}/hotTablets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListInstances' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/instances',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListLogicalViews' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/logicalViews',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMaterializedViews' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/materializedViews',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PartialUpdateCluster' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{cluster.name=projects/*/instances/*/clusters/*}',
                'body' => 'cluster',
                'placeholders' => [
                    'cluster.name' => [
                        'getters' => [
                            'getCluster',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'PartialUpdateInstance' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{instance.name=projects/*/instances/*}',
                'body' => 'instance',
                'placeholders' => [
                    'instance.name' => [
                        'getters' => [
                            'getInstance',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=projects/*/instances/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{resource=projects/*/instances/*/materializedViews/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{resource=projects/*/instances/*/logicalViews/*}:setIamPolicy',
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
                'uriTemplate' => '/v2/{resource=projects/*/instances/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{resource=projects/*/instances/*/materializedViews/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{resource=projects/*/instances/*/logicalViews/*}:testIamPermissions',
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
            'UpdateAppProfile' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{app_profile.name=projects/*/instances/*/appProfiles/*}',
                'body' => 'app_profile',
                'placeholders' => [
                    'app_profile.name' => [
                        'getters' => [
                            'getAppProfile',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateCluster' => [
                'method' => 'put',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/clusters/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateInstance' => [
                'method' => 'put',
                'uriTemplate' => '/v2/{name=projects/*/instances/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateLogicalView' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{logical_view.name=projects/*/instances/*/logicalViews/*}',
                'body' => 'logical_view',
                'placeholders' => [
                    'logical_view.name' => [
                        'getters' => [
                            'getLogicalView',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateMaterializedView' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{materialized_view.name=projects/*/instances/*/materializedViews/*}',
                'body' => 'materialized_view',
                'placeholders' => [
                    'materialized_view.name' => [
                        'getters' => [
                            'getMaterializedView',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=operations/**}:cancel',
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
                'uriTemplate' => '/v2/{name=operations/**}',
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
                'uriTemplate' => '/v2/{name=operations/**}',
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
                'uriTemplate' => '/v2/{name=operations/projects/**}/operations',
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
