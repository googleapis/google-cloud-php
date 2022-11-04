<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.BackendServices' => [
            'AddSignedUrlKey' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices/{backend_service}/addSignedUrlKey',
                'body' => 'signed_url_key_resource',
                'placeholders' => [
                    'backend_service' => [
                        'getters' => [
                            'getBackendService',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/backendServices',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices/{backend_service}',
                'placeholders' => [
                    'backend_service' => [
                        'getters' => [
                            'getBackendService',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'DeleteSignedUrlKey' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices/{backend_service}/deleteSignedUrlKey',
                'placeholders' => [
                    'backend_service' => [
                        'getters' => [
                            'getBackendService',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
                'queryParams' => [
                    'key_name',
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices/{backend_service}',
                'placeholders' => [
                    'backend_service' => [
                        'getters' => [
                            'getBackendService',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'GetHealth' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices/{backend_service}/getHealth',
                'body' => 'resource_group_reference_resource',
                'placeholders' => [
                    'backend_service' => [
                        'getters' => [
                            'getBackendService',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices/{resource}/getIamPolicy',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices',
                'body' => 'backend_service_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices/{backend_service}',
                'body' => 'backend_service_resource',
                'placeholders' => [
                    'backend_service' => [
                        'getters' => [
                            'getBackendService',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetEdgeSecurityPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices/{backend_service}/setEdgeSecurityPolicy',
                'body' => 'security_policy_reference_resource',
                'placeholders' => [
                    'backend_service' => [
                        'getters' => [
                            'getBackendService',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices/{resource}/setIamPolicy',
                'body' => 'global_set_policy_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'SetSecurityPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices/{backend_service}/setSecurityPolicy',
                'body' => 'security_policy_reference_resource',
                'placeholders' => [
                    'backend_service' => [
                        'getters' => [
                            'getBackendService',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Update' => [
                'method' => 'put',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendServices/{backend_service}',
                'body' => 'backend_service_resource',
                'placeholders' => [
                    'backend_service' => [
                        'getters' => [
                            'getBackendService',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.compute.v1.GlobalOperations' => [
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/operations',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Wait' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}/wait',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
