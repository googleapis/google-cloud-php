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
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.video.livestream.v1.LivestreamService' => [
            'CreateAsset' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/assets',
                'body' => 'asset',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'asset_id',
                ],
            ],
            'CreateChannel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/channels',
                'body' => 'channel',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'channel_id',
                ],
            ],
            'CreateClip' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/channels/*}/clips',
                'body' => 'clip',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'clip_id',
                ],
            ],
            'CreateDvrSession' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/channels/*}/dvrSessions',
                'body' => 'dvr_session',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'dvr_session_id',
                ],
            ],
            'CreateEvent' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/channels/*}/events',
                'body' => 'event',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'event_id',
                ],
            ],
            'CreateInput' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/inputs',
                'body' => 'input',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'input_id',
                ],
            ],
            'DeleteAsset' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/assets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteChannel' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteClip' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*/clips/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDvrSession' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*/dvrSessions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteEvent' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*/events/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteInput' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/inputs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAsset' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/assets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetChannel' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetClip' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*/clips/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDvrSession' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*/dvrSessions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEvent' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*/events/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInput' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/inputs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPool' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/pools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAssets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/assets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListChannels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/channels',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListClips' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/channels/*}/clips',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDvrSessions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/channels/*}/dvrSessions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEvents' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/channels/*}/events',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListInputs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/inputs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'StartChannel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*}:start',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StopChannel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*}:stop',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateChannel' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{channel.name=projects/*/locations/*/channels/*}',
                'body' => 'channel',
                'placeholders' => [
                    'channel.name' => [
                        'getters' => [
                            'getChannel',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateDvrSession' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{dvr_session.name=projects/*/locations/*/channels/*/dvrSessions/*}',
                'body' => 'dvr_session',
                'placeholders' => [
                    'dvr_session.name' => [
                        'getters' => [
                            'getDvrSession',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateInput' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{input.name=projects/*/locations/*/inputs/*}',
                'body' => 'input',
                'placeholders' => [
                    'input.name' => [
                        'getters' => [
                            'getInput',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePool' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{pool.name=projects/*/locations/*/pools/*}',
                'body' => 'pool',
                'placeholders' => [
                    'pool.name' => [
                        'getters' => [
                            'getPool',
                            'getName',
                        ],
                    ],
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
