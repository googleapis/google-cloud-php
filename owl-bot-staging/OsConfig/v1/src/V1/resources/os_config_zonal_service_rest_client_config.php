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
        'google.cloud.osconfig.v1.OsConfigZonalService' => [
            'CreateOSPolicyAssignment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/osPolicyAssignments',
                'body' => 'os_policy_assignment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'os_policy_assignment_id',
                ],
            ],
            'DeleteOSPolicyAssignment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/osPolicyAssignments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInventory' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/inventory}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOSPolicyAssignment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/osPolicyAssignments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOSPolicyAssignmentReport' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/osPolicyAssignments/*/report}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVulnerabilityReport' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/vulnerabilityReport}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListInventories' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/inventories',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOSPolicyAssignmentReports' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*/osPolicyAssignments/*}/reports',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOSPolicyAssignmentRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/osPolicyAssignments/*}:listRevisions',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOSPolicyAssignments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/osPolicyAssignments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVulnerabilityReports' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/vulnerabilityReports',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateOSPolicyAssignment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{os_policy_assignment.name=projects/*/locations/*/osPolicyAssignments/*}',
                'body' => 'os_policy_assignment',
                'placeholders' => [
                    'os_policy_assignment.name' => [
                        'getters' => [
                            'getOsPolicyAssignment',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/osPolicyAssignments/*/operations/*}:cancel',
                'body' => '*',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/osPolicyAssignments/*/operations/*}',
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
