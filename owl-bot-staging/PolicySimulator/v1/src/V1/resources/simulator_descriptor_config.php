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
        'google.cloud.policysimulator.v1.Simulator' => [
            'CreateReplay' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\PolicySimulator\V1\Replay',
                    'metadataReturnType' => '\Google\Cloud\PolicySimulator\V1\ReplayOperationMetadata',
                    'initialPollDelayMillis' => '1000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '10000',
                    'totalPollTimeoutMillis' => '18000000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetReplay' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PolicySimulator\V1\Replay',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListReplayResults' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getReplayResults',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\PolicySimulator\V1\ListReplayResultsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'folderLocationReplay' => 'folders/{folder}/locations/{location}/replays/{replay}',
                'organizationLocationReplay' => 'organizations/{organization}/locations/{location}/replays/{replay}',
                'projectLocationReplay' => 'projects/{project}/locations/{location}/replays/{replay}',
                'replay' => 'projects/{project}/locations/{location}/replays/{replay}',
            ],
        ],
    ],
];
