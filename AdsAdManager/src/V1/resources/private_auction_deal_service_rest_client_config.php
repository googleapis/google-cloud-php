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
        'google.ads.admanager.v1.PrivateAuctionDealService' => [
            'CreatePrivateAuctionDeal' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/privateAuctionDeals',
                'body' => 'private_auction_deal',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetPrivateAuctionDeal' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/privateAuctionDeals/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListPrivateAuctionDeals' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/privateAuctionDeals',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdatePrivateAuctionDeal' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{private_auction_deal.name=networks/*/privateAuctionDeals/*}',
                'body' => 'private_auction_deal',
                'placeholders' => [
                    'private_auction_deal.name' => [
                        'getters' => [
                            'getPrivateAuctionDeal',
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
