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
        'google.cloud.compute.v1.FirewallPolicies' => [
            'AddAssociation' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                    'getOperationRequest' => '\Google\Cloud\Compute\V1\GetGlobalOrganizationOperationRequest',
                    'cancelOperationRequest' => null,
                    'deleteOperationRequest' => '\Google\Cloud\Compute\V1\DeleteGlobalOrganizationOperationRequest',
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'firewall_policy',
                        'fieldAccessors' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'AddRule' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                    'getOperationRequest' => '\Google\Cloud\Compute\V1\GetGlobalOrganizationOperationRequest',
                    'cancelOperationRequest' => null,
                    'deleteOperationRequest' => '\Google\Cloud\Compute\V1\DeleteGlobalOrganizationOperationRequest',
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'firewall_policy',
                        'fieldAccessors' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'CloneRules' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                    'getOperationRequest' => '\Google\Cloud\Compute\V1\GetGlobalOrganizationOperationRequest',
                    'cancelOperationRequest' => null,
                    'deleteOperationRequest' => '\Google\Cloud\Compute\V1\DeleteGlobalOrganizationOperationRequest',
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'firewall_policy',
                        'fieldAccessors' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                    'getOperationRequest' => '\Google\Cloud\Compute\V1\GetGlobalOrganizationOperationRequest',
                    'cancelOperationRequest' => null,
                    'deleteOperationRequest' => '\Google\Cloud\Compute\V1\DeleteGlobalOrganizationOperationRequest',
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'firewall_policy',
                        'fieldAccessors' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                    'getOperationRequest' => '\Google\Cloud\Compute\V1\GetGlobalOrganizationOperationRequest',
                    'cancelOperationRequest' => null,
                    'deleteOperationRequest' => '\Google\Cloud\Compute\V1\DeleteGlobalOrganizationOperationRequest',
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
            ],
            'Move' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                    'getOperationRequest' => '\Google\Cloud\Compute\V1\GetGlobalOrganizationOperationRequest',
                    'cancelOperationRequest' => null,
                    'deleteOperationRequest' => '\Google\Cloud\Compute\V1\DeleteGlobalOrganizationOperationRequest',
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'firewall_policy',
                        'fieldAccessors' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                    'getOperationRequest' => '\Google\Cloud\Compute\V1\GetGlobalOrganizationOperationRequest',
                    'cancelOperationRequest' => null,
                    'deleteOperationRequest' => '\Google\Cloud\Compute\V1\DeleteGlobalOrganizationOperationRequest',
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'firewall_policy',
                        'fieldAccessors' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'PatchRule' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                    'getOperationRequest' => '\Google\Cloud\Compute\V1\GetGlobalOrganizationOperationRequest',
                    'cancelOperationRequest' => null,
                    'deleteOperationRequest' => '\Google\Cloud\Compute\V1\DeleteGlobalOrganizationOperationRequest',
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'firewall_policy',
                        'fieldAccessors' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'RemoveAssociation' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                    'getOperationRequest' => '\Google\Cloud\Compute\V1\GetGlobalOrganizationOperationRequest',
                    'cancelOperationRequest' => null,
                    'deleteOperationRequest' => '\Google\Cloud\Compute\V1\DeleteGlobalOrganizationOperationRequest',
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'firewall_policy',
                        'fieldAccessors' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'RemoveRule' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                    'getOperationRequest' => '\Google\Cloud\Compute\V1\GetGlobalOrganizationOperationRequest',
                    'cancelOperationRequest' => null,
                    'deleteOperationRequest' => '\Google\Cloud\Compute\V1\DeleteGlobalOrganizationOperationRequest',
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'firewall_policy',
                        'fieldAccessors' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\FirewallPolicy',
                'headerParams' => [
                    [
                        'keyName' => 'firewall_policy',
                        'fieldAccessors' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'GetAssociation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\FirewallPolicyAssociation',
                'headerParams' => [
                    [
                        'keyName' => 'firewall_policy',
                        'fieldAccessors' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetRule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\FirewallPolicyRule',
                'headerParams' => [
                    [
                        'keyName' => 'firewall_policy',
                        'fieldAccessors' => [
                            'getFirewallPolicy',
                        ],
                    ],
                ],
            ],
            'List' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getMaxResults',
                    'requestPageSizeSetMethod' => 'setMaxResults',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getItems',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\FirewallPolicyList',
            ],
            'ListAssociations' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\FirewallPoliciesListAssociationsResponse',
            ],
            'SetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\TestPermissionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
