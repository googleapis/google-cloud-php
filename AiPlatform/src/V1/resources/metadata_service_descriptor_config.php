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
            'CreateMetadataStore' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\MetadataStore',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\CreateMetadataStoreOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteArtifact' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\DeleteOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteContext' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\DeleteOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteExecution' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\DeleteOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMetadataStore' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\DeleteMetadataStoreOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'PurgeArtifacts' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\PurgeArtifactsResponse',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\PurgeArtifactsMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PurgeContexts' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\PurgeContextsResponse',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\PurgeContextsMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PurgeExecutions' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\PurgeExecutionsResponse',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\PurgeExecutionsMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'AddContextArtifactsAndExecutions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\AddContextArtifactsAndExecutionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'context',
                        'fieldAccessors' => [
                            'getContext',
                        ],
                    ],
                ],
            ],
            'AddContextChildren' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\AddContextChildrenResponse',
                'headerParams' => [
                    [
                        'keyName' => 'context',
                        'fieldAccessors' => [
                            'getContext',
                        ],
                    ],
                ],
            ],
            'AddExecutionEvents' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\AddExecutionEventsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'execution',
                        'fieldAccessors' => [
                            'getExecution',
                        ],
                    ],
                ],
            ],
            'CreateArtifact' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\Artifact',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateContext' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\Context',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateExecution' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\Execution',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateMetadataSchema' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\MetadataSchema',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetArtifact' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\Artifact',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetContext' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\Context',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetExecution' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\Execution',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMetadataSchema' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\MetadataSchema',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMetadataStore' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\MetadataStore',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListArtifacts' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getArtifacts',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\ListArtifactsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListContexts' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getContexts',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\ListContextsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListExecutions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getExecutions',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\ListExecutionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMetadataSchemas' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMetadataSchemas',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\ListMetadataSchemasResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMetadataStores' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMetadataStores',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\ListMetadataStoresResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'QueryArtifactLineageSubgraph' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\LineageSubgraph',
                'headerParams' => [
                    [
                        'keyName' => 'artifact',
                        'fieldAccessors' => [
                            'getArtifact',
                        ],
                    ],
                ],
            ],
            'QueryContextLineageSubgraph' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\LineageSubgraph',
                'headerParams' => [
                    [
                        'keyName' => 'context',
                        'fieldAccessors' => [
                            'getContext',
                        ],
                    ],
                ],
            ],
            'QueryExecutionInputsAndOutputs' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\LineageSubgraph',
                'headerParams' => [
                    [
                        'keyName' => 'execution',
                        'fieldAccessors' => [
                            'getExecution',
                        ],
                    ],
                ],
            ],
            'RemoveContextChildren' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\RemoveContextChildrenResponse',
                'headerParams' => [
                    [
                        'keyName' => 'context',
                        'fieldAccessors' => [
                            'getContext',
                        ],
                    ],
                ],
            ],
            'UpdateArtifact' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\Artifact',
                'headerParams' => [
                    [
                        'keyName' => 'artifact.name',
                        'fieldAccessors' => [
                            'getArtifact',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateContext' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\Context',
                'headerParams' => [
                    [
                        'keyName' => 'context.name',
                        'fieldAccessors' => [
                            'getContext',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateExecution' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\Execution',
                'headerParams' => [
                    [
                        'keyName' => 'execution.name',
                        'fieldAccessors' => [
                            'getExecution',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLocation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Location\Location',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.cloud.location.Locations',
            ],
            'ListLocations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLocations',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Location\ListLocationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.cloud.location.Locations',
            ],
            'GetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'SetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'TestIamPermissions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\TestIamPermissionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'templateMap' => [
                'artifact' => 'projects/{project}/locations/{location}/metadataStores/{metadata_store}/artifacts/{artifact}',
                'context' => 'projects/{project}/locations/{location}/metadataStores/{metadata_store}/contexts/{context}',
                'execution' => 'projects/{project}/locations/{location}/metadataStores/{metadata_store}/executions/{execution}',
                'location' => 'projects/{project}/locations/{location}',
                'metadataSchema' => 'projects/{project}/locations/{location}/metadataStores/{metadata_store}/metadataSchemas/{metadata_schema}',
                'metadataStore' => 'projects/{project}/locations/{location}/metadataStores/{metadata_store}',
            ],
        ],
    ],
];
