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
        'google.monitoring.v3.AlertPolicyService' => [
            'CreateAlertPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\AlertPolicy',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAlertPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAlertPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\AlertPolicy',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAlertPolicies' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAlertPolicies',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\ListAlertPoliciesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAlertPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\AlertPolicy',
                'headerParams' => [
                    [
                        'keyName' => 'alert_policy.name',
                        'fieldAccessors' => [
                            'getAlertPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'alertPolicy' => 'projects/{project}/alertPolicies/{alert_policy}',
                'alertPolicyCondition' => 'projects/{project}/alertPolicies/{alert_policy}/conditions/{condition}',
                'folderAlertPolicy' => 'folders/{folder}/alertPolicies/{alert_policy}',
                'folderAlertPolicyCondition' => 'folders/{folder}/alertPolicies/{alert_policy}/conditions/{condition}',
                'organizationAlertPolicy' => 'organizations/{organization}/alertPolicies/{alert_policy}',
                'organizationAlertPolicyCondition' => 'organizations/{organization}/alertPolicies/{alert_policy}/conditions/{condition}',
                'projectAlertPolicy' => 'projects/{project}/alertPolicies/{alert_policy}',
                'projectAlertPolicyCondition' => 'projects/{project}/alertPolicies/{alert_policy}/conditions/{condition}',
            ],
        ],
    ],
];
