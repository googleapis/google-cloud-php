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
        'google.cloud.discoveryengine.v1.LicenseConfigService' => [
            'CreateLicenseConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\LicenseConfig',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DistributeLicenseConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\DistributeLicenseConfigResponse',
                'headerParams' => [
                    [
                        'keyName' => 'billing_account_license_config',
                        'fieldAccessors' => [
                            'getBillingAccountLicenseConfig',
                        ],
                    ],
                ],
            ],
            'GetLicenseConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\LicenseConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLicenseConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLicenseConfigs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\ListLicenseConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RetractLicenseConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\RetractLicenseConfigResponse',
                'headerParams' => [
                    [
                        'keyName' => 'billing_account_license_config',
                        'fieldAccessors' => [
                            'getBillingAccountLicenseConfig',
                        ],
                    ],
                ],
            ],
            'UpdateLicenseConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\LicenseConfig',
                'headerParams' => [
                    [
                        'keyName' => 'license_config.name',
                        'fieldAccessors' => [
                            'getLicenseConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'billingAccountLicenseConfig' => 'billingAccounts/{billing_account}/billingAccountLicenseConfigs/{billing_account_license_config}',
                'licenseConfig' => 'projects/{project}/locations/{location}/licenseConfigs/{license_config}',
                'location' => 'projects/{project}/locations/{location}',
            ],
        ],
    ],
];
