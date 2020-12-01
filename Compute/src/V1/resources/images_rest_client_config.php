<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.Images' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/images/{image}',
                'placeholders' => [
                    'image' => [
                        'getters' => [
                            'getImage',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Deprecate' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/images/{image}/deprecate',
                'body' => 'deprecation_status_resource',
                'placeholders' => [
                    'image' => [
                        'getters' => [
                            'getImage',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/images/{image}',
                'placeholders' => [
                    'image' => [
                        'getters' => [
                            'getImage',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'GetFromFamily' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/images/family/{family}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'family' => [
                        'getters' => [
                            'getFamily',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/images/{resource}/getIamPolicy',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/images',
                'body' => 'image_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/images',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/images/{image}',
                'body' => 'image_resource',
                'placeholders' => [
                    'image' => [
                        'getters' => [
                            'getImage',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/images/{resource}/setIamPolicy',
                'body' => 'global_set_policy_request_resource',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetLabels' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/images/{resource}/setLabels',
                'body' => 'global_set_labels_request_resource',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/images/{resource}/testIamPermissions',
                'body' => 'test_permissions_request_resource',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
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
