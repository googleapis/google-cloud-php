<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.UrlMaps' => [
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/urlMaps',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/urlMaps/{url_map}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'url_map' => [
                        'getters' => [
                            'getUrlMap',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/urlMaps/{url_map}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'url_map' => [
                        'getters' => [
                            'getUrlMap',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/urlMaps',
                'body' => 'url_map_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'InvalidateCache' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/urlMaps/{url_map}/invalidateCache',
                'body' => 'cache_invalidation_rule_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'url_map' => [
                        'getters' => [
                            'getUrlMap',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/urlMaps',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/urlMaps/{url_map}',
                'body' => 'url_map_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'url_map' => [
                        'getters' => [
                            'getUrlMap',
                        ],
                    ],
                ],
            ],
            'Update' => [
                'method' => 'put',
                'uriTemplate' => '/compute/v1/projects/{project}/global/urlMaps/{url_map}',
                'body' => 'url_map_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'url_map' => [
                        'getters' => [
                            'getUrlMap',
                        ],
                    ],
                ],
            ],
            'Validate' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/urlMaps/{url_map}/validate',
                'body' => 'url_maps_validate_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'url_map' => [
                        'getters' => [
                            'getUrlMap',
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
