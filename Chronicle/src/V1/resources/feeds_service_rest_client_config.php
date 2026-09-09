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
        'google.cloud.chronicle.v1.FeedsService' => [
            'CreateFeed' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/feeds',
                'body' => 'feed',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteFeed' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/feeds/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DisableFeed' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/feeds/*}:disable',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'EnableFeed' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/feeds/*}:enable',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchServiceAccountForCustomer' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/feedServiceAccounts:fetchServiceAccountForCustomer',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GenerateSecret' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/feeds/*}:generateSecret',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFeed' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/feeds/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFeedPack' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/feedPacks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportPushLogs' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*/feeds/*}:importPushLogs',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListFeedPacks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/feedPacks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListFeedSourceTypeSchemas' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/feedSourceTypeSchemas',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListFeeds' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/feeds',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListLogTypeSchemas' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*/feedSourceTypeSchemas/*}/logTypeSchemas',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateFeed' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{feed.name=projects/*/locations/*/instances/*/feeds/*}',
                'body' => 'feed',
                'placeholders' => [
                    'feed.name' => [
                        'getters' => [
                            'getFeed',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/operations/*}:cancel',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*}/operations',
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
