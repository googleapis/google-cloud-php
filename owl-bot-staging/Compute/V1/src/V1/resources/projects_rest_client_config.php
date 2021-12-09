<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.Projects' => [
            'DisableXpnHost' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/disableXpnHost',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'DisableXpnResource' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/disableXpnResource',
                'body' => 'projects_disable_xpn_resource_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'EnableXpnHost' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/enableXpnHost',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'EnableXpnResource' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/enableXpnResource',
                'body' => 'projects_enable_xpn_resource_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'GetXpnHost' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/getXpnHost',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'GetXpnResources' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/getXpnResources',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'ListXpnHosts' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/listXpnHosts',
                'body' => 'projects_list_xpn_hosts_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'MoveDisk' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/moveDisk',
                'body' => 'disk_move_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'MoveInstance' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/moveInstance',
                'body' => 'instance_move_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetCommonInstanceMetadata' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/setCommonInstanceMetadata',
                'body' => 'metadata_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetDefaultNetworkTier' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/setDefaultNetworkTier',
                'body' => 'projects_set_default_network_tier_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetUsageExportBucket' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/setUsageExportBucket',
                'body' => 'usage_export_location_resource',
                'placeholders' => [
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
