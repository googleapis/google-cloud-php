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
        'google.devtools.clouderrorreporting.v1beta1.ErrorStatsService' => [
            'DeleteEvents' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ErrorReporting\V1beta1\DeleteEventsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_name',
                        'fieldAccessors' => [
                            'getProjectName',
                        ],
                    ],
                ],
            ],
            'ListEvents' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getErrorEvents',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ErrorReporting\V1beta1\ListEventsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_name',
                        'fieldAccessors' => [
                            'getProjectName',
                        ],
                    ],
                ],
            ],
            'ListGroupStats' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getErrorGroupStats',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ErrorReporting\V1beta1\ListGroupStatsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_name',
                        'fieldAccessors' => [
                            'getProjectName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'project' => 'projects/{project}',
            ],
        ],
    ],
];
