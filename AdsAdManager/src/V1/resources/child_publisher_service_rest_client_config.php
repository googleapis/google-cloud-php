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
        'google.ads.admanager.v1.ChildPublisherService' => [
            'BatchCreateChildPublishers' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/childPublishers:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRejectChildPublishers' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/childPublishers:batchReject',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRenegotiateChildPublisherAgreements' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/childPublishers:batchRenegotiateAgreements',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchResendChildPublisherInvitationEmails' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/childPublishers:batchResendInvitationEmails',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateChildPublishers' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/childPublishers:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchWithdrawChildPublishers' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/childPublishers:batchWithdraw',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateChildPublisher' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/childPublishers',
                'body' => 'child_publisher',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetChildPublisher' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/childPublishers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListChildPublishers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/childPublishers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateChildPublisher' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{child_publisher.name=networks/*/childPublishers/*}',
                'body' => 'child_publisher',
                'placeholders' => [
                    'child_publisher.name' => [
                        'getters' => [
                            'getChildPublisher',
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
