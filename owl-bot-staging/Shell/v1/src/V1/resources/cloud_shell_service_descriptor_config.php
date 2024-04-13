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
        'google.cloud.shell.v1.CloudShellService' => [
            'AddPublicKey' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Shell\V1\AddPublicKeyResponse',
                    'metadataReturnType' => '\Google\Cloud\Shell\V1\AddPublicKeyMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'environment',
                        'fieldAccessors' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'AuthorizeEnvironment' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Shell\V1\AuthorizeEnvironmentResponse',
                    'metadataReturnType' => '\Google\Cloud\Shell\V1\AuthorizeEnvironmentMetadata',
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
            'RemovePublicKey' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Shell\V1\RemovePublicKeyResponse',
                    'metadataReturnType' => '\Google\Cloud\Shell\V1\RemovePublicKeyMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'environment',
                        'fieldAccessors' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'StartEnvironment' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Shell\V1\StartEnvironmentResponse',
                    'metadataReturnType' => '\Google\Cloud\Shell\V1\StartEnvironmentMetadata',
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
            'GetEnvironment' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Shell\V1\Environment',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'environment' => 'users/{user}/environments/{environment}',
            ],
        ],
    ],
];
