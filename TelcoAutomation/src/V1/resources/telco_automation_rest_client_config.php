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
                'uriTemplate' => '/v1/{name=projects/*/locations}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.telcoautomation.v1.TelcoAutomation' => [
            'ApplyDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/deployments/*}:apply',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ApplyHydratedDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/deployments/*/hydratedDeployments/*}:apply',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ApproveBlueprint' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/blueprints/*}:approve',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ComputeDeploymentStatus' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/deployments/*}:computeDeploymentStatus',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateBlueprint' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/orchestrationClusters/*}/blueprints',
                'body' => 'blueprint',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/orchestrationClusters/*}/deployments',
                'body' => 'deployment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateEdgeSlm' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/edgeSlms',
                'body' => 'edge_slm',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'edge_slm_id',
                ],
            ],
            'CreateOrchestrationCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/orchestrationClusters',
                'body' => 'orchestration_cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'orchestration_cluster_id',
                ],
            ],
            'DeleteBlueprint' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/blueprints/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteEdgeSlm' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/edgeSlms/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOrchestrationCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DiscardBlueprintChanges' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/blueprints/*}:discard',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DiscardDeploymentChanges' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/deployments/*}:discard',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBlueprint' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/blueprints/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDeployment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/deployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEdgeSlm' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/edgeSlms/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetHydratedDeployment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/deployments/*/hydratedDeployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOrchestrationCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPublicBlueprint' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/publicBlueprints/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBlueprintRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/blueprints/*}:listRevisions',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBlueprints' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/orchestrationClusters/*}/blueprints',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDeploymentRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/deployments/*}:listRevisions',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDeployments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/orchestrationClusters/*}/deployments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEdgeSlms' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/edgeSlms',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListHydratedDeployments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/orchestrationClusters/*/deployments/*}/hydratedDeployments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOrchestrationClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/orchestrationClusters',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPublicBlueprints' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/publicBlueprints',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ProposeBlueprint' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/blueprints/*}:propose',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RejectBlueprint' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/blueprints/*}:reject',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RemoveDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/deployments/*}:remove',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RollbackDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/orchestrationClusters/*/deployments/*}:rollback',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchBlueprintRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/orchestrationClusters/*}/blueprints:searchRevisions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchDeploymentRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/orchestrationClusters/*}/deployments:searchRevisions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateBlueprint' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{blueprint.name=projects/*/locations/*/orchestrationClusters/*/blueprints/*}',
                'body' => 'blueprint',
                'placeholders' => [
                    'blueprint.name' => [
                        'getters' => [
                            'getBlueprint',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateDeployment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{deployment.name=projects/*/locations/*/orchestrationClusters/*/deployments/*}',
                'body' => 'deployment',
                'placeholders' => [
                    'deployment.name' => [
                        'getters' => [
                            'getDeployment',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateHydratedDeployment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{hydrated_deployment.name=projects/*/locations/*/orchestrationClusters/*/deployments/*/hydratedDeployments/*}',
                'body' => 'hydrated_deployment',
                'placeholders' => [
                    'hydrated_deployment.name' => [
                        'getters' => [
                            'getHydratedDeployment',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations}',
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
