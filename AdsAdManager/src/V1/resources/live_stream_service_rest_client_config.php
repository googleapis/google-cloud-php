<?php
/*
 * Copyright 2026 Google LLC
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
        'google.ads.admanager.v1.LiveStreamService' => [
            'BatchActivateLiveStreams' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/liveStreams:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchArchiveLiveStreams' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/liveStreams:batchArchive',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateLiveStreams' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/liveStreams:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchPauseAdsLiveStreams' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/liveStreams:batchPauseAds',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchPauseLiveStreams' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/liveStreams:batchPause',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRefreshMasterPlaylists' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/liveStreams:batchRefreshMasterPlaylists',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateLiveStreams' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/liveStreams:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateLiveStream' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/liveStreams',
                'body' => 'live_stream',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetLiveStream' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/liveStreams/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLiveStreams' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/liveStreams',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateLiveStream' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{live_stream.name=networks/*/liveStreams/*}',
                'body' => 'live_stream',
                'placeholders' => [
                    'live_stream.name' => [
                        'getters' => [
                            'getLiveStream',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}:cancel',
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
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}',
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
