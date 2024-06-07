<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

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
            'CreateLiveConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/liveConfigs',
                'body' => 'live_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'live_config_id',
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
            'CreateVodConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/vodConfigs',
                'body' => 'vod_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'vod_config_id',
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
            'DeleteLiveConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/liveConfigs/*}',
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
            'DeleteVodConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/vodConfigs/*}',
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
            'GetLiveConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/liveConfigs/*}',
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
            'GetVodConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/vodConfigs/*}',
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
            'ListLiveConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/liveConfigs',
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
            'ListVodConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/vodConfigs',
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
            'UpdateLiveConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{live_config.name=projects/*/locations/*/liveConfigs/*}',
                'body' => 'live_config',
                'placeholders' => [
                    'live_config.name' => [
                        'getters' => [
                            'getLiveConfig',
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
            'UpdateVodConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{vod_config.name=projects/*/locations/*/vodConfigs/*}',
                'body' => 'vod_config',
                'placeholders' => [
                    'vod_config.name' => [
                        'getters' => [
                            'getVodConfig',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
    'numericEnums' => true,
];
