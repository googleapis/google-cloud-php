<?php

return [
    'interfaces' => [
        'google.cloud.baremetalsolution.v2.BareMetalSolution' => [
            'DetachLun' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{instance=projects/*/locations/*/instances/*}:detachLun',
                'body' => '*',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'GetInstance' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLun' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*/luns/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNetwork' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/networks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNfsShare' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/nfsShares/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVolume' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListInstances' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/instances',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListLuns' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/volumes/*}/luns',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNetworkUsage' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{location=projects/*/locations/*}/networks:listNetworkUsage',
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'ListNetworks' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/networks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNfsShares' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/nfsShares',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVolumes' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/volumes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ResetInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}:reset',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResizeVolume' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{volume=projects/*/locations/*/volumes/*}:resize',
                'body' => '*',
                'placeholders' => [
                    'volume' => [
                        'getters' => [
                            'getVolume',
                        ],
                    ],
                ],
            ],
            'StartInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}:start',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StopInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}:stop',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateInstance' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{instance.name=projects/*/locations/*/instances/*}',
                'body' => 'instance',
                'placeholders' => [
                    'instance.name' => [
                        'getters' => [
                            'getInstance',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateNetwork' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{network.name=projects/*/locations/*/networks/*}',
                'body' => 'network',
                'placeholders' => [
                    'network.name' => [
                        'getters' => [
                            'getNetwork',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateNfsShare' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{nfs_share.name=projects/*/locations/*/nfsShares/*}',
                'body' => 'nfs_share',
                'placeholders' => [
                    'nfs_share.name' => [
                        'getters' => [
                            'getNfsShare',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateVolume' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{volume.name=projects/*/locations/*/volumes/*}',
                'body' => 'volume',
                'placeholders' => [
                    'volume.name' => [
                        'getters' => [
                            'getVolume',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v2/{name=projects/*}/locations',
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
];
