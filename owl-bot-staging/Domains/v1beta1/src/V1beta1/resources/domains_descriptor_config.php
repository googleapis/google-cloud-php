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
        'google.cloud.domains.v1beta1.Domains' => [
            'ConfigureContactSettings' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ConfigureDnsSettings' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ConfigureManagementSettings' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteRegistration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ExportRegistration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'RegisterDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'TransferDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateRegistration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Domains\V1beta1\Registration',
                    'metadataReturnType' => '\Google\Cloud\Domains\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListRegistrations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getRegistrations',
                ],
            ],
        ],
    ],
];
