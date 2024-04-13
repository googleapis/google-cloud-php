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
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/topics/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/subscriptions/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/snapshots/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/schemas/*}:getIamPolicy',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/topics/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/subscriptions/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/snapshots/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/schemas/*}:setIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/subscriptions/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/topics/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/snapshots/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/schemas/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
        ],
        'google.pubsub.v1.Publisher' => [
            'CreateTopic' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{name=projects/*/topics/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTopic' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{topic=projects/*/topics/*}',
                'placeholders' => [
                    'topic' => [
                        'getters' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'DetachSubscription' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{subscription=projects/*/subscriptions/*}:detach',
                'placeholders' => [
                    'subscription' => [
                        'getters' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'GetTopic' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{topic=projects/*/topics/*}',
                'placeholders' => [
                    'topic' => [
                        'getters' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'ListTopicSnapshots' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{topic=projects/*/topics/*}/snapshots',
                'placeholders' => [
                    'topic' => [
                        'getters' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'ListTopicSubscriptions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{topic=projects/*/topics/*}/subscriptions',
                'placeholders' => [
                    'topic' => [
                        'getters' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'ListTopics' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{project=projects/*}/topics',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Publish' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{topic=projects/*/topics/*}:publish',
                'body' => '*',
                'placeholders' => [
                    'topic' => [
                        'getters' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'UpdateTopic' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{topic.name=projects/*/topics/*}',
                'body' => '*',
                'placeholders' => [
                    'topic.name' => [
                        'getters' => [
                            'getTopic',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
