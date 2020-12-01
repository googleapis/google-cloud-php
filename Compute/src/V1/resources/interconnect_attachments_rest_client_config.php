<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.InterconnectAttachments' => [
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/interconnectAttachments',
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
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/interconnectAttachments/{interconnect_attachment}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'interconnect_attachment' => [
                        'getters' => [
                            'getInterconnectAttachment',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/interconnectAttachments/{interconnect_attachment}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'interconnect_attachment' => [
                        'getters' => [
                            'getInterconnectAttachment',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/interconnectAttachments',
                'body' => 'interconnect_attachment_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/interconnectAttachments',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/interconnectAttachments/{interconnect_attachment}',
                'body' => 'interconnect_attachment_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'interconnect_attachment' => [
                        'getters' => [
                            'getInterconnectAttachment',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
