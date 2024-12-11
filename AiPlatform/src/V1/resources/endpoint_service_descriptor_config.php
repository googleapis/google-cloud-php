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
        'google.cloud.aiplatform.v1.EndpointService' => [
            'CreateEndpoint' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\Endpoint',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\CreateEndpointOperationMetadata',
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
            'DeleteEndpoint' => [
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
            'DeployModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\DeployModelResponse',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\DeployModelOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'endpoint',
                        'fieldAccessors' => [
                            'getEndpoint',
                        ],
                    ],
                ],
            ],
            'MutateDeployedModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\MutateDeployedModelResponse',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\MutateDeployedModelOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'endpoint',
                        'fieldAccessors' => [
                            'getEndpoint',
                        ],
                    ],
                ],
            ],
            'UndeployModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\UndeployModelResponse',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\UndeployModelOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'endpoint',
                        'fieldAccessors' => [
                            'getEndpoint',
                        ],
                    ],
                ],
            ],
            'UpdateEndpointLongRunning' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AIPlatform\V1\Endpoint',
                    'metadataReturnType' => '\Google\Cloud\AIPlatform\V1\UpdateEndpointOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'endpoint.name',
                        'fieldAccessors' => [
                            'getEndpoint',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEndpoint' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\Endpoint',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListEndpoints' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getEndpoints',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\ListEndpointsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateEndpoint' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AIPlatform\V1\Endpoint',
                'headerParams' => [
                    [
                        'keyName' => 'endpoint.name',
                        'fieldAccessors' => [
                            'getEndpoint',
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
                'deploymentResourcePool' => 'projects/{project}/locations/{location}/deploymentResourcePools/{deployment_resource_pool}',
                'endpoint' => 'projects/{project}/locations/{location}/endpoints/{endpoint}',
                'location' => 'projects/{project}/locations/{location}',
                'model' => 'projects/{project}/locations/{location}/models/{model}',
                'modelDeploymentMonitoringJob' => 'projects/{project}/locations/{location}/modelDeploymentMonitoringJobs/{model_deployment_monitoring_job}',
                'network' => 'projects/{project}/global/networks/{network}',
                'projectLocationEndpoint' => 'projects/{project}/locations/{location}/endpoints/{endpoint}',
                'projectLocationPublisherModel' => 'projects/{project}/locations/{location}/publishers/{publisher}/models/{model}',
                'reservation' => 'projects/{project_id_or_number}/zones/{zone}/reservations/{reservation_name}',
            ],
        ],
    ],
];
