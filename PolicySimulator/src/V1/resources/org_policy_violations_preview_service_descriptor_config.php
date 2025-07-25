<?php
/*
 * Copyright 2025 Google LLC
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
        'google.cloud.policysimulator.v1.OrgPolicyViolationsPreviewService' => [
            'CreateOrgPolicyViolationsPreview' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\PolicySimulator\V1\OrgPolicyViolationsPreview',
                    'metadataReturnType' => '\Google\Cloud\PolicySimulator\V1\CreateOrgPolicyViolationsPreviewOperationMetadata',
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
            'GetOrgPolicyViolationsPreview' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PolicySimulator\V1\OrgPolicyViolationsPreview',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOrgPolicyViolations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getOrgPolicyViolations',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\PolicySimulator\V1\ListOrgPolicyViolationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOrgPolicyViolationsPreviews' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getOrgPolicyViolationsPreviews',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\PolicySimulator\V1\ListOrgPolicyViolationsPreviewsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'customConstraint' => 'organizations/{organization}/customConstraints/{custom_constraint}',
                'folder' => 'folders/{folder}',
                'folderPolicy' => 'folders/{folder}/policies/{policy}',
                'orgPolicyViolationsPreview' => 'organizations/{organization}/locations/{location}/orgPolicyViolationsPreviews/{org_policy_violations_preview}',
                'organization' => 'organizations/{organization}',
                'organizationLocation' => 'organizations/{organization}/locations/{location}',
                'organizationPolicy' => 'organizations/{organization}/policies/{policy}',
                'policy' => 'projects/{project}/policies/{policy}',
                'project' => 'projects/{project}',
                'projectPolicy' => 'projects/{project}/policies/{policy}',
            ],
        ],
    ],
];
