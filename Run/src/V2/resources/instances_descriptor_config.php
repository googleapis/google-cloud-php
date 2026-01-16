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
        'google.cloud.run.v2.Instances' => [
            'CreateInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Instance',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Instance',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'DeleteInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Instance',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Instance',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'StartInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Instance',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Instance',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StopInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Instance',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Instance',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInstance' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Run\V2\Instance',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'ListInstances' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getInstances',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Run\V2\ListInstancesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'templateMap' => [
                'connector' => 'projects/{project}/locations/{location}/connectors/{connector}',
                'cryptoKey' => 'projects/{project}/locations/{location}/keyRings/{key_ring}/cryptoKeys/{crypto_key}',
                'instance' => 'projects/{project}/locations/{location}/instances/{instance}',
                'location' => 'projects/{project}/locations/{location}',
                'locationPolicy' => 'locations/{location}/policy',
                'policy' => 'projects/{project}/policy',
                'projectPolicy' => 'projects/{project}/policy',
                'secret' => 'projects/{project}/secrets/{secret}',
                'secretVersion' => 'projects/{project}/secrets/{secret}/versions/{version}',
            ],
        ],
    ],
];
