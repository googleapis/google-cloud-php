<?php
/*
 * Copyright 2026 Google LLC
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
        'google.cloud.auditmanager.v1.AuditManager' => [
            'GenerateAuditReport' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\AuditManager\V1\AuditReport',
                    'metadataReturnType' => '\Google\Cloud\AuditManager\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'scope',
                        'fieldAccessors' => [
                            'getScope',
                        ],
                    ],
                ],
            ],
            'EnrollResource' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AuditManager\V1\Enrollment',
                'headerParams' => [
                    [
                        'keyName' => 'scope',
                        'fieldAccessors' => [
                            'getScope',
                        ],
                    ],
                ],
            ],
            'GenerateAuditScopeReport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AuditManager\V1\AuditScopeReport',
                'headerParams' => [
                    [
                        'keyName' => 'scope',
                        'fieldAccessors' => [
                            'getScope',
                        ],
                    ],
                ],
            ],
            'GetAuditReport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AuditManager\V1\AuditReport',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetResourceEnrollmentStatus' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AuditManager\V1\ResourceEnrollmentStatus',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAuditReports' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAuditReports',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\AuditManager\V1\ListAuditReportsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListControls' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getControls',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\AuditManager\V1\ListControlsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListResourceEnrollmentStatuses' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getResourceEnrollmentStatuses',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\AuditManager\V1\ListResourceEnrollmentStatusesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
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
            'templateMap' => [
                'auditReport' => 'projects/{project}/locations/{location}/auditReports/{audit_report}',
                'enrollmentStatusScope' => 'folders/{folder}/locations/{location}',
                'folderLocation' => 'folders/{folder}/locations/{location}',
                'folderLocationAuditReport' => 'folders/{folder}/locations/{location}/auditReports/{audit_report}',
                'folderLocationResourceEnrollmentStatus' => 'folders/{folder}/locations/{location}/resourceEnrollmentStatuses/{resource_enrollment_status}',
                'folderLocationStandard' => 'folders/{folder}/locations/{location}/standards/{standard}',
                'location' => 'projects/{project}/locations/{location}',
                'organizationLocation' => 'organizations/{organization}/locations/{location}',
                'organizationLocationResourceEnrollmentStatus' => 'organizations/{organization}/locations/{location}/resourceEnrollmentStatuses/{resource_enrollment_status}',
                'organizationLocationStandard' => 'organizations/{organization}/locations/{location}/standards/{standard}',
                'projectLocationAuditReport' => 'projects/{project}/locations/{location}/auditReports/{audit_report}',
                'projectLocationResourceEnrollmentStatus' => 'projects/{project}/locations/{location}/resourceEnrollmentStatuses/{resource_enrollment_status}',
                'projectLocationStandard' => 'projects/{project}/locations/{location}/standards/{standard}',
                'resourceEnrollmentStatus' => 'folders/{folder}/locations/{location}/resourceEnrollmentStatuses/{resource_enrollment_status}',
                'standard' => 'projects/{project}/locations/{location}/standards/{standard}',
            ],
        ],
    ],
];
