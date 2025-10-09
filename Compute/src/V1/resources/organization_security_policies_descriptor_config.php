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
        'google.cloud.compute.v1.OrganizationSecurityPolicies' => [
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
                        'keyName' => 'security_policy',
                        'fieldAccessors' => [
                            'getSecurityPolicy',
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
                        'keyName' => 'security_policy',
                        'fieldAccessors' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'CopyRules' => [
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
                        'keyName' => 'security_policy',
                        'fieldAccessors' => [
                            'getSecurityPolicy',
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
                        'keyName' => 'security_policy',
                        'fieldAccessors' => [
                            'getSecurityPolicy',
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
                        'keyName' => 'security_policy',
                        'fieldAccessors' => [
                            'getSecurityPolicy',
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
                        'keyName' => 'security_policy',
                        'fieldAccessors' => [
                            'getSecurityPolicy',
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
                        'keyName' => 'security_policy',
                        'fieldAccessors' => [
                            'getSecurityPolicy',
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
                        'keyName' => 'security_policy',
                        'fieldAccessors' => [
                            'getSecurityPolicy',
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
                        'keyName' => 'security_policy',
                        'fieldAccessors' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\SecurityPolicy',
                'headerParams' => [
                    [
                        'keyName' => 'security_policy',
                        'fieldAccessors' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'GetAssociation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\SecurityPolicyAssociation',
                'headerParams' => [
                    [
                        'keyName' => 'security_policy',
                        'fieldAccessors' => [
                            'getSecurityPolicy',
                        ],
                    ],
                ],
            ],
            'GetRule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\SecurityPolicyRule',
                'headerParams' => [
                    [
                        'keyName' => 'security_policy',
                        'fieldAccessors' => [
                            'getSecurityPolicy',
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
                'responseType' => 'Google\Cloud\Compute\V1\SecurityPolicyList',
            ],
            'ListAssociations' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\OrganizationSecurityPoliciesListAssociationsResponse',
            ],
            'ListPreconfiguredExpressionSets' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\SecurityPoliciesListPreconfiguredExpressionSetsResponse',
            ],
        ],
    ],
];
