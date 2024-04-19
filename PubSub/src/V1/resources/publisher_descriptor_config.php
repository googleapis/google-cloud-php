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
        'google.pubsub.v1.Publisher' => [
            'CreateTopic' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\Topic',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTopic' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'topic',
                        'fieldAccessors' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'DetachSubscription' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\DetachSubscriptionResponse',
                'headerParams' => [
                    [
                        'keyName' => 'subscription',
                        'fieldAccessors' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'GetTopic' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\Topic',
                'headerParams' => [
                    [
                        'keyName' => 'topic',
                        'fieldAccessors' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'ListTopicSnapshots' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSnapshots',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\ListTopicSnapshotsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'topic',
                        'fieldAccessors' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'ListTopicSubscriptions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSubscriptions',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\ListTopicSubscriptionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'topic',
                        'fieldAccessors' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'ListTopics' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTopics',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\ListTopicsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Publish' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\PublishResponse',
                'headerParams' => [
                    [
                        'keyName' => 'topic',
                        'fieldAccessors' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'UpdateTopic' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\Topic',
                'headerParams' => [
                    [
                        'keyName' => 'topic.name',
                        'fieldAccessors' => [
                            'getTopic',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'SetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'TestIamPermissions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\TestIamPermissionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'templateMap' => [
                'deletedTopic' => '_deleted-topic_',
                'project' => 'projects/{project}',
                'projectTopic' => 'projects/{project}/topics/{topic}',
                'schema' => 'projects/{project}/schemas/{schema}',
                'subscription' => 'projects/{project}/subscriptions/{subscription}',
                'topic' => 'projects/{project}/topics/{topic}',
            ],
        ],
    ],
];
