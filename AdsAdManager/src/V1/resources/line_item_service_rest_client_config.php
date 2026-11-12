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
        'google.ads.admanager.v1.LineItemService' => [
            'BatchActivateLineItems' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchArchiveLineItems' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems:batchArchive',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateLineItems' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeleteLineItems' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems:batchDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchPauseLineItems' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems:batchPause',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchReleaseLineItems' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems:batchRelease',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchReserveAndOverbookLineItems' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems:batchReserveAndOverbook',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchReserveLineItems' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems:batchReserve',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchResumeAndOverbookLineItems' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems:batchResumeAndOverbook',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchResumeLineItems' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems:batchResume',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUnarchiveLineItems' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems:batchUnarchive',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateLineItems' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateLineItem' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems',
                'body' => 'line_item',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetLineItem' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/lineItems/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLineItems' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/lineItems',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateLineItem' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{line_item.name=networks/*/lineItems/*}',
                'body' => 'line_item',
                'placeholders' => [
                    'line_item.name' => [
                        'getters' => [
                            'getLineItem',
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
