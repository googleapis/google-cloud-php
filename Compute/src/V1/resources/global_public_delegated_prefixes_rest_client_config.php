<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.GlobalPublicDelegatedPrefixes' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicDelegatedPrefixes/{public_delegated_prefix}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'public_delegated_prefix' => [
                        'getters' => [
                            'getPublicDelegatedPrefix',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicDelegatedPrefixes/{public_delegated_prefix}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'public_delegated_prefix' => [
                        'getters' => [
                            'getPublicDelegatedPrefix',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicDelegatedPrefixes',
                'body' => 'public_delegated_prefix_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicDelegatedPrefixes',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicDelegatedPrefixes/{public_delegated_prefix}',
                'body' => 'public_delegated_prefix_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'public_delegated_prefix' => [
                        'getters' => [
                            'getPublicDelegatedPrefix',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
