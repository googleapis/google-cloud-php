<?php

return [
    'interfaces' => [
        'google.cloud.video.stitcher.v1.VideoStitcherService' => [
            'CreateCdnKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/cdnKeys',
                'body' => 'cdn_key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'cdn_key_id',
                ],
            ],
            'CreateLiveSession' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/liveSessions',
                'body' => 'live_session',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSlate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/slates',
                'body' => 'slate',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'slate_id',
                ],
            ],
            'CreateVodSession' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/vodSessions',
                'body' => 'vod_session',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteCdnKey' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/cdnKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSlate' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/slates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCdnKey' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/cdnKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLiveAdTagDetail' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/liveSessions/*/liveAdTagDetails/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLiveSession' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/liveSessions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSlate' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/slates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVodAdTagDetail' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/vodSessions/*/vodAdTagDetails/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVodSession' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/vodSessions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVodStitchDetail' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/vodSessions/*/vodStitchDetails/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCdnKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/cdnKeys',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListLiveAdTagDetails' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/liveSessions/*}/liveAdTagDetails',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSlates' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/slates',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVodAdTagDetails' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/vodSessions/*}/vodAdTagDetails',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVodStitchDetails' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/vodSessions/*}/vodStitchDetails',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCdnKey' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{cdn_key.name=projects/*/locations/*/cdnKeys/*}',
                'body' => 'cdn_key',
                'placeholders' => [
                    'cdn_key.name' => [
                        'getters' => [
                            'getCdnKey',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSlate' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{slate.name=projects/*/locations/*/slates/*}',
                'body' => 'slate',
                'placeholders' => [
                    'slate.name' => [
                        'getters' => [
                            'getSlate',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
];
