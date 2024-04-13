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
        'google.cloud.managedidentities.v1beta1.ManagedIdentitiesService' => [
            'AttachTrust' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateMicrosoftAdDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DetachTrust' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ReconfigureTrust' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ValidateTrust' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListDomains' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDomains',
                ],
            ],
        ],
    ],
];
