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
        'google.cloud.apphub.v1.AppHub' => [
            'CreateApplication' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/applications',
                'body' => 'application',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'application_id',
                ],
            ],
            'CreateService' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/applications/*}/services',
                'body' => 'service',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'service_id',
                ],
            ],
            'CreateServiceProjectAttachment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/serviceProjectAttachments',
                'body' => 'service_project_attachment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'service_project_attachment_id',
                ],
            ],
            'CreateWorkload' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/applications/*}/workloads',
                'body' => 'workload',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'workload_id',
                ],
            ],
            'DeleteApplication' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteService' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*/services/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteServiceProjectAttachment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/serviceProjectAttachments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteWorkload' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*/workloads/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DetachServiceProjectAttachment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}:detachServiceProjectAttachment',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApplication' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDiscoveredService' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/discoveredServices/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDiscoveredWorkload' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/discoveredWorkloads/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetService' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*/services/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetServiceProjectAttachment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/serviceProjectAttachments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetWorkload' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*/workloads/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListApplications' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/applications',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDiscoveredServices' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/discoveredServices',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDiscoveredWorkloads' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/discoveredWorkloads',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListServiceProjectAttachments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/serviceProjectAttachments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListServices' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/applications/*}/services',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListWorkloads' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/applications/*}/workloads',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LookupDiscoveredService' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/discoveredServices:lookup',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LookupDiscoveredWorkload' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/discoveredWorkloads:lookup',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LookupServiceProjectAttachment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}:lookupServiceProjectAttachment',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApplication' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{application.name=projects/*/locations/*/applications/*}',
                'body' => 'application',
                'placeholders' => [
                    'application.name' => [
                        'getters' => [
                            'getApplication',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateService' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{service.name=projects/*/locations/*/applications/*/services/*}',
                'body' => 'service',
                'placeholders' => [
                    'service.name' => [
                        'getters' => [
                            'getService',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateWorkload' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{workload.name=projects/*/locations/*/applications/*/workloads/*}',
                'body' => 'workload',
                'placeholders' => [
                    'workload.name' => [
                        'getters' => [
                            'getWorkload',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/applications/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/applications/*}:setIamPolicy',
                'body' => '*',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/applications/*}:testIamPermissions',
                'body' => '*',
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
