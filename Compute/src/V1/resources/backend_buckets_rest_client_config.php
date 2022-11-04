<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.BackendBuckets' => [
            'AddSignedUrlKey' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendBuckets/{backend_bucket}/addSignedUrlKey',
                'body' => 'signed_url_key_resource',
                'placeholders' => [
                    'backend_bucket' => [
                        'getters' => [
                            'getBackendBucket',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendBuckets/{backend_bucket}',
                'placeholders' => [
                    'backend_bucket' => [
                        'getters' => [
                            'getBackendBucket',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendBuckets/{backend_bucket}/deleteSignedUrlKey',
                'placeholders' => [
                    'backend_bucket' => [
                        'getters' => [
                            'getBackendBucket',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendBuckets/{backend_bucket}',
                'placeholders' => [
                    'backend_bucket' => [
                        'getters' => [
                            'getBackendBucket',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendBuckets',
                'body' => 'backend_bucket_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendBuckets',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendBuckets/{backend_bucket}',
                'body' => 'backend_bucket_resource',
                'placeholders' => [
                    'backend_bucket' => [
                        'getters' => [
                            'getBackendBucket',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendBuckets/{backend_bucket}/setEdgeSecurityPolicy',
                'body' => 'security_policy_reference_resource',
                'placeholders' => [
                    'backend_bucket' => [
                        'getters' => [
                            'getBackendBucket',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/backendBuckets/{backend_bucket}',
                'body' => 'backend_bucket_resource',
                'placeholders' => [
                    'backend_bucket' => [
                        'getters' => [
                            'getBackendBucket',
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
