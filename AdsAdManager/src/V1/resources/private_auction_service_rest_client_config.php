<?php
/*
 * Copyright 2025 Google LLC
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
        'google.ads.admanager.v1.PrivateAuctionService' => [
            'CreatePrivateAuction' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/privateAuctions',
                'body' => 'private_auction',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetPrivateAuction' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/privateAuctions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListPrivateAuctions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/privateAuctions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdatePrivateAuction' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{private_auction.name=networks/*/privateAuctions/*}',
                'body' => 'private_auction',
                'placeholders' => [
                    'private_auction.name' => [
                        'getters' => [
                            'getPrivateAuction',
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
