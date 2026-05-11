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
        'google.ads.admanager.v1.AdUnitService' => [
            'BatchActivateAdUnits' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchActivateAdUnitsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchArchiveAdUnits' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchArchiveAdUnitsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateAdUnits' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchCreateAdUnitsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivateAdUnits' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchDeactivateAdUnitsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateAdUnits' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchUpdateAdUnitsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAdUnit' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\AdUnit',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetAdUnit' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\AdUnit',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAdUnitSizes' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAdUnitSizes',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\ListAdUnitSizesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAdUnits' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAdUnits',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\ListAdUnitsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAdUnit' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\AdUnit',
                'headerParams' => [
                    [
                        'keyName' => 'ad_unit.name',
                        'fieldAccessors' => [
                            'getAdUnit',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'adUnit' => 'networks/{network_code}/adUnits/{ad_unit}',
                'label' => 'networks/{network_code}/labels/{label}',
                'network' => 'networks/{network_code}',
                'team' => 'networks/{network_code}/teams/{team}',
            ],
        ],
    ],
];
