<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.PublicAdvertisedPrefixes' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicAdvertisedPrefixes/{public_advertised_prefix}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'public_advertised_prefix' => [
                        'getters' => [
                            'getPublicAdvertisedPrefix',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicAdvertisedPrefixes/{public_advertised_prefix}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'public_advertised_prefix' => [
                        'getters' => [
                            'getPublicAdvertisedPrefix',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicAdvertisedPrefixes',
                'body' => 'public_advertised_prefix_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicAdvertisedPrefixes',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicAdvertisedPrefixes/{public_advertised_prefix}',
                'body' => 'public_advertised_prefix_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'public_advertised_prefix' => [
                        'getters' => [
                            'getPublicAdvertisedPrefix',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
