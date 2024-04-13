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
        'google.cloud.security.privateca.v1beta1.CertificateAuthorityService' => [
            'ActivateCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DisableCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'EnableCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'RestoreCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ScheduleDeleteCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateCertificateRevocationList' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateRevocationList',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListCertificateAuthorities' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCertificateAuthorities',
                ],
            ],
            'ListCertificateRevocationLists' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCertificateRevocationLists',
                ],
            ],
            'ListCertificates' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCertificates',
                ],
            ],
            'ListReusableConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getReusableConfigs',
                ],
            ],
        ],
    ],
];
