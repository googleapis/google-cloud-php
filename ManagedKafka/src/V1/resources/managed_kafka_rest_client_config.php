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
        'google.cloud.managedkafka.v1.ManagedKafka' => [
            'AddAclEntry' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{acl=projects/*/locations/*/clusters/*/acls/**}:addAclEntry',
                'body' => 'acl_entry',
                'placeholders' => [
                    'acl' => [
                        'getters' => [
                            'getAcl',
                        ],
                    ],
                ],
            ],
            'CreateAcl' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/acls',
                'body' => 'acl',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'acl_id',
                ],
            ],
            'CreateCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/clusters',
                'body' => 'cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'cluster_id',
                ],
            ],
            'CreateTopic' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/topics',
                'body' => 'topic',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'topic_id',
                ],
            ],
            'DeleteAcl' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/acls/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteConsumerGroup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/consumerGroups/**}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/topics/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAcl' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/acls/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConsumerGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/consumerGroups/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTopic' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/topics/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAcls' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/acls',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/clusters',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListConsumerGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/consumerGroups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTopics' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/topics',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RemoveAclEntry' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{acl=projects/*/locations/*/clusters/*/acls/**}:removeAclEntry',
                'body' => 'acl_entry',
                'placeholders' => [
                    'acl' => [
                        'getters' => [
                            'getAcl',
                        ],
                    ],
                ],
            ],
            'UpdateAcl' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{acl.name=projects/*/locations/*/clusters/*/acls/**}',
                'body' => 'acl',
                'placeholders' => [
                    'acl.name' => [
                        'getters' => [
                            'getAcl',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCluster' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{cluster.name=projects/*/locations/*/clusters/*}',
                'body' => 'cluster',
                'placeholders' => [
                    'cluster.name' => [
                        'getters' => [
                            'getCluster',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateConsumerGroup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{consumer_group.name=projects/*/locations/*/clusters/*/consumerGroups/**}',
                'body' => 'consumer_group',
                'placeholders' => [
                    'consumer_group.name' => [
                        'getters' => [
                            'getConsumerGroup',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateTopic' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{topic.name=projects/*/locations/*/clusters/*/topics/*}',
                'body' => 'topic',
                'placeholders' => [
                    'topic.name' => [
                        'getters' => [
                            'getTopic',
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
