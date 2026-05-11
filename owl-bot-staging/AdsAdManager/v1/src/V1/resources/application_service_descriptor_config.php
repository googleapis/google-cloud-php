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
        'google.ads.admanager.v1.ApplicationService' => [
            'BatchArchiveApplications' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchArchiveApplicationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateApplications' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchCreateApplicationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUnarchiveApplications' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchUnarchiveApplicationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateApplications' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchUpdateApplicationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateApplication' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\Application',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetApplication' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\Application',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListApplications' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getApplications',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\ListApplicationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateApplication' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\Application',
                'headerParams' => [
                    [
                        'keyName' => 'application.name',
                        'fieldAccessors' => [
                            'getApplication',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'application' => 'networks/{network_code}/applications/{application}',
                'network' => 'networks/{network_code}',
            ],
        ],
    ],
];
