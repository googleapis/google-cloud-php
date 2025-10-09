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
        'google.cloud.deploy.v1.CloudDeploy' => [
            'AbandonRelease' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*}:abandon',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'AdvanceRollout' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*}:advance',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ApproveRollout' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*}:approve',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelAutomationRun' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/automationRuns/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelRollout' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateAutomation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*}/automations',
                'body' => 'automation',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'automation_id',
                ],
            ],
            'CreateCustomTargetType' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/customTargetTypes',
                'body' => 'custom_target_type',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'custom_target_type_id',
                ],
            ],
            'CreateDeliveryPipeline' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/deliveryPipelines',
                'body' => 'delivery_pipeline',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'delivery_pipeline_id',
                ],
            ],
            'CreateDeployPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/deployPolicies',
                'body' => 'deploy_policy',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'deploy_policy_id',
                ],
            ],
            'CreateRelease' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*}/releases',
                'body' => 'release',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'release_id',
                ],
            ],
            'CreateRollout' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*/releases/*}/rollouts',
                'body' => 'rollout',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'rollout_id',
                ],
            ],
            'CreateTarget' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/targets',
                'body' => 'target',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'target_id',
                ],
            ],
            'DeleteAutomation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/automations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCustomTargetType' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/customTargetTypes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDeliveryPipeline' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDeployPolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deployPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTarget' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/targets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAutomation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/automations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAutomationRun' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/automationRuns/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/config}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCustomTargetType' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/customTargetTypes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDeliveryPipeline' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDeployPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deployPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetJobRun' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*/jobRuns/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRelease' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRollout' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTarget' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/targets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'IgnoreJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{rollout=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*}:ignoreJob',
                'body' => '*',
                'placeholders' => [
                    'rollout' => [
                        'getters' => [
                            'getRollout',
                        ],
                    ],
                ],
            ],
            'ListAutomationRuns' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*}/automationRuns',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAutomations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*}/automations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCustomTargetTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/customTargetTypes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDeliveryPipelines' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/deliveryPipelines',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDeployPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/deployPolicies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListJobRuns' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*}/jobRuns',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListReleases' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*}/releases',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRollouts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*/releases/*}/rollouts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTargets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/targets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RetryJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{rollout=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*}:retryJob',
                'body' => '*',
                'placeholders' => [
                    'rollout' => [
                        'getters' => [
                            'getRollout',
                        ],
                    ],
                ],
            ],
            'RollbackTarget' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*}:rollbackTarget',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'TerminateJobRun' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*/jobRuns/*}:terminate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAutomation' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{automation.name=projects/*/locations/*/deliveryPipelines/*/automations/*}',
                'body' => 'automation',
                'placeholders' => [
                    'automation.name' => [
                        'getters' => [
                            'getAutomation',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateCustomTargetType' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{custom_target_type.name=projects/*/locations/*/customTargetTypes/*}',
                'body' => 'custom_target_type',
                'placeholders' => [
                    'custom_target_type.name' => [
                        'getters' => [
                            'getCustomTargetType',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateDeliveryPipeline' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{delivery_pipeline.name=projects/*/locations/*/deliveryPipelines/*}',
                'body' => 'delivery_pipeline',
                'placeholders' => [
                    'delivery_pipeline.name' => [
                        'getters' => [
                            'getDeliveryPipeline',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateDeployPolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{deploy_policy.name=projects/*/locations/*/deployPolicies/*}',
                'body' => 'deploy_policy',
                'placeholders' => [
                    'deploy_policy.name' => [
                        'getters' => [
                            'getDeployPolicy',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateTarget' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{target.name=projects/*/locations/*/targets/*}',
                'body' => 'target',
                'placeholders' => [
                    'target.name' => [
                        'getters' => [
                            'getTarget',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/deliveryPipelines/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/targets/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/customTargetTypes/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/deployPolicies/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/deliveryPipelines/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/targets/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/customTargetTypes/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/deployPolicies/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/deliveryPipelines/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/targets/*}:testIamPermissions',
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
