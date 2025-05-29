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
        'google.cloud.aiplatform.v1.MetadataService' => [
            'AddContextArtifactsAndExecutions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{context=projects/*/locations/*/metadataStores/*/contexts/*}:addContextArtifactsAndExecutions',
                'body' => '*',
                'placeholders' => [
                    'context' => [
                        'getters' => [
                            'getContext',
                        ],
                    ],
                ],
            ],
            'AddContextChildren' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{context=projects/*/locations/*/metadataStores/*/contexts/*}:addContextChildren',
                'body' => '*',
                'placeholders' => [
                    'context' => [
                        'getters' => [
                            'getContext',
                        ],
                    ],
                ],
            ],
            'AddExecutionEvents' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{execution=projects/*/locations/*/metadataStores/*/executions/*}:addExecutionEvents',
                'body' => '*',
                'placeholders' => [
                    'execution' => [
                        'getters' => [
                            'getExecution',
                        ],
                    ],
                ],
            ],
            'CreateArtifact' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/metadataStores/*}/artifacts',
                'body' => 'artifact',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateContext' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/metadataStores/*}/contexts',
                'body' => 'context',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateExecution' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/metadataStores/*}/executions',
                'body' => 'execution',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateMetadataSchema' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/metadataStores/*}/metadataSchemas',
                'body' => 'metadata_schema',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateMetadataStore' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/metadataStores',
                'body' => 'metadata_store',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteArtifact' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/artifacts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteContext' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/contexts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteExecution' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/executions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMetadataStore' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetArtifact' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/artifacts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetContext' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/contexts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetExecution' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/executions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMetadataSchema' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/metadataSchemas/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMetadataStore' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListArtifacts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/metadataStores/*}/artifacts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListContexts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/metadataStores/*}/contexts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListExecutions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/metadataStores/*}/executions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMetadataSchemas' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/metadataStores/*}/metadataSchemas',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMetadataStores' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/metadataStores',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PurgeArtifacts' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/metadataStores/*}/artifacts:purge',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PurgeContexts' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/metadataStores/*}/contexts:purge',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PurgeExecutions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/metadataStores/*}/executions:purge',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'QueryArtifactLineageSubgraph' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{artifact=projects/*/locations/*/metadataStores/*/artifacts/*}:queryArtifactLineageSubgraph',
                'placeholders' => [
                    'artifact' => [
                        'getters' => [
                            'getArtifact',
                        ],
                    ],
                ],
            ],
            'QueryContextLineageSubgraph' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{context=projects/*/locations/*/metadataStores/*/contexts/*}:queryContextLineageSubgraph',
                'placeholders' => [
                    'context' => [
                        'getters' => [
                            'getContext',
                        ],
                    ],
                ],
            ],
            'QueryExecutionInputsAndOutputs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{execution=projects/*/locations/*/metadataStores/*/executions/*}:queryExecutionInputsAndOutputs',
                'placeholders' => [
                    'execution' => [
                        'getters' => [
                            'getExecution',
                        ],
                    ],
                ],
            ],
            'RemoveContextChildren' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{context=projects/*/locations/*/metadataStores/*/contexts/*}:removeContextChildren',
                'body' => '*',
                'placeholders' => [
                    'context' => [
                        'getters' => [
                            'getContext',
                        ],
                    ],
                ],
            ],
            'UpdateArtifact' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{artifact.name=projects/*/locations/*/metadataStores/*/artifacts/*}',
                'body' => 'artifact',
                'placeholders' => [
                    'artifact.name' => [
                        'getters' => [
                            'getArtifact',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateContext' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{context.name=projects/*/locations/*/metadataStores/*/contexts/*}',
                'body' => 'context',
                'placeholders' => [
                    'context.name' => [
                        'getters' => [
                            'getContext',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateExecution' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{execution.name=projects/*/locations/*/metadataStores/*/executions/*}',
                'body' => 'execution',
                'placeholders' => [
                    'execution.name' => [
                        'getters' => [
                            'getExecution',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/ui/{name=projects/*/locations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/ui/{name=projects/*}/locations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*}/locations',
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
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/featurestores/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/featurestores/*/entityTypes/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/models/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/notebookRuntimeTemplates/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/featureOnlineStores/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/featureOnlineStores/*/featureViews/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featurestores/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featurestores/*/entityTypes/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/models/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/endpoints/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/notebookRuntimeTemplates/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/publishers/*/models/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featureOnlineStores/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featureOnlineStores/*/featureViews/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featureGroups/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/featurestores/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/featurestores/*/entityTypes/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/models/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/notebookRuntimeTemplates/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/featureOnlineStores/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/featureOnlineStores/*/featureViews/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featurestores/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featurestores/*/entityTypes/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/models/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/endpoints/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/notebookRuntimeTemplates/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featureOnlineStores/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featureOnlineStores/*/featureViews/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featureGroups/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/featurestores/*}:testIamPermissions',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/featurestores/*/entityTypes/*}:testIamPermissions',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/models/*}:testIamPermissions',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/notebookRuntimeTemplates/*}:testIamPermissions',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/featureOnlineStores/*}:testIamPermissions',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/featureOnlineStores/*/featureViews/*}:testIamPermissions',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featurestores/*}:testIamPermissions',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featurestores/*/entityTypes/*}:testIamPermissions',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/models/*}:testIamPermissions',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/endpoints/*}:testIamPermissions',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/notebookRuntimeTemplates/*}:testIamPermissions',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featureOnlineStores/*}:testIamPermissions',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featureOnlineStores/*/featureViews/*}:testIamPermissions',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featureGroups/*}:testIamPermissions',
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
                'uriTemplate' => '/ui/{name=projects/*/locations/*/operations/*}:cancel',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/agents/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/apps/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/edgeDevices/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/endpoints/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/extensionControllers/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/extensions/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/customJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tuningJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexes/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexEndpoints/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/artifacts/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/contexts/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/executions/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelMonitors/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/migratableResources/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookExecutionJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookRuntimes/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookRuntimeTemplates/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/persistentResources/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/trials/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/trainingPipelines/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/pipelineJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/schedules/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/ragEngineConfig/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/specialistPools/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/endpoints/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tuningJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexes/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/artifacts/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/contexts/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/executions/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/migratableResources/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookExecutionJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookRuntimes/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookRuntimeTemplates/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/persistentResources/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragEngineConfig/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragCorpora/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragCorpora/*/ragFiles/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/reasoningEngines/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/trials/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/trainingPipelines/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/pipelineJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schedules/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/specialistPools/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}:cancel',
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
                'uriTemplate' => '/ui/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/agents/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/apps/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/edgeDevices/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/endpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/extensionControllers/*}/operations',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/extensions/*}/operations',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/customJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexes/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexEndpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/artifacts/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/contexts/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/executions/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelMonitors/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/migratableResources/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookExecutionJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookRuntimes/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookRuntimeTemplates/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/persistentResources/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/trials/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/trainingPipelines/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/pipelineJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/schedules/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/specialistPools/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/ragEngineConfig/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureOnlineStores/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureGroups/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureGroups/*/features/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureGroups/*/featureMonitors/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureOnlineStores/*/featureViews/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/endpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexes/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/artifacts/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/contexts/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/executions/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/migratableResources/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookExecutionJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookRuntimes/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookRuntimeTemplates/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragEngineConfig/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragCorpora/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragCorpora/*/ragFiles/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/reasoningEngines/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/trials/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/trainingPipelines/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/persistentResources/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/pipelineJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schedules/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/specialistPools/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureOnlineStores/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureGroups/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureGroups/*/features/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureOnlineStores/*/featureViews/*/operations/*}',
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
                'uriTemplate' => '/ui/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/agents/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/apps/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/edgeDeploymentJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/edgeDevices/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/endpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/extensionControllers/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/extensions/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/customJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tuningJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexEndpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/artifacts/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/contexts/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/executions/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelMonitors/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/migratableResources/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookExecutionJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookRuntimes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookRuntimeTemplates/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/persistentResources/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/trials/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/trainingPipelines/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/pipelineJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/ragEngineConfig/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/schedules/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/specialistPools/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureOnlineStores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureOnlineStores/*/featureViews/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureGroups/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureGroups/*/features/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureGroups/*/featureMonitors/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/endpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tuningJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/artifacts/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/contexts/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/executions/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/migratableResources/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookExecutionJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookRuntimes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookRuntimeTemplates/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragEngineConfig/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragCorpora/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragCorpora/*/ragFiles/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/reasoningEngines/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/trials/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/trainingPipelines/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/persistentResources/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/pipelineJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schedules/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/specialistPools/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureOnlineStores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureOnlineStores/*/featureViews/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureGroups/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureGroups/*/features/*/operations/*}',
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
                'uriTemplate' => '/ui/{name=projects/*/locations/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/agents/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/apps/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/savedQueries/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/annotationSpecs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/deploymentResourcePools/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/edgeDevices/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/endpoints/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/extensionControllers/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/extensions/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/customJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/dataLabelingJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/hyperparameterTuningJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tuningJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexes/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexEndpoints/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/artifacts/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/contexts/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/executions/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelMonitors/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/migratableResources/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/evaluations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookExecutionJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookRuntimes/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookRuntimeTemplates/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/trials/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/trainingPipelines/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/persistentResources/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/pipelineJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/ragEngineConfig}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/schedules/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/specialistPools/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureOnlineStores/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureOnlineStores/*/featureViews/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureGroups/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureGroups/*/features/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureGroups/*/featureMonitors/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/savedQueries/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/annotationSpecs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/deploymentResourcePools/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/endpoints/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tuningJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexes/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/artifacts/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/contexts/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/executions/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/migratableResources/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/evaluations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookExecutionJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookRuntimes/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookRuntimeTemplates/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/reasoningEngines/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/trials/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/trainingPipelines/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/persistentResources/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/pipelineJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragEngineConfig}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragCorpora/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragCorpora/*/ragFiles/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schedules/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/specialistPools/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureOnlineStores/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureOnlineStores/*/featureViews/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureGroups/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureGroups/*/features/*/operations/*}:wait',
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
            'WaitOperation' => [
                'method' => 'post',
                'uriTemplate' => '/ui/{name=projects/*/locations/*/operations/*}:wait',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/agents/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/apps/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/edgeDevices/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/endpoints/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/extensionControllers/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/extensions/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/customJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tuningJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexes/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexEndpoints/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/artifacts/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/contexts/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/metadataStores/*/executions/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelMonitors/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/migratableResources/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookExecutionJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookRuntimes/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/notebookRuntimeTemplates/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/trials/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/trainingPipelines/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/persistentResources/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/pipelineJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/schedules/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/specialistPools/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/ragEngineConfig/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureOnlineStores/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureOnlineStores/*/featureViews/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureGroups/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureGroups/*/features/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featureGroups/*/featureMonitors/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/endpoints/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexes/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/artifacts/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/contexts/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/metadataStores/*/executions/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/migratableResources/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookExecutionJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookRuntimes/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notebookRuntimeTemplates/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragEngineConfig/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragCorpora/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/ragCorpora/*/ragFiles/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/reasoningEngines/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/trials/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/trainingPipelines/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/persistentResources/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/pipelineJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schedules/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/specialistPools/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureOnlineStores/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureOnlineStores/*/featureViews/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureGroups/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featureGroups/*/features/*/operations/*}:wait',
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
