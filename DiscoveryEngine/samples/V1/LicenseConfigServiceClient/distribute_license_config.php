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

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START discoveryengine_v1_generated_LicenseConfigService_DistributeLicenseConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\LicenseConfigServiceClient;
use Google\Cloud\DiscoveryEngine\V1\DistributeLicenseConfigRequest;
use Google\Cloud\DiscoveryEngine\V1\DistributeLicenseConfigResponse;

/**
 * Distributes a
 * [LicenseConfig][google.cloud.discoveryengine.v1.LicenseConfig] from billing
 * account level to project level.
 *
 * @param string $formattedBillingAccountLicenseConfig Full resource name of [BillingAccountLicenseConfig][].
 *
 *                                                     Format:
 *                                                     `billingAccounts/{billing_account}/billingAccountLicenseConfigs/{billing_account_license_config_id}`. Please see
 *                                                     {@see LicenseConfigServiceClient::billingAccountLicenseConfigName()} for help formatting this field.
 * @param int    $projectNumber                        The target GCP project number to distribute the license config
 *                                                     to.
 * @param string $location                             The target GCP project region to distribute the license config
 *                                                     to.
 * @param int    $licenseCount                         The number of licenses to distribute.
 */
function distribute_license_config_sample(
    string $formattedBillingAccountLicenseConfig,
    int $projectNumber,
    string $location,
    int $licenseCount
): void {
    // Create a client.
    $licenseConfigServiceClient = new LicenseConfigServiceClient();

    // Prepare the request message.
    $request = (new DistributeLicenseConfigRequest())
        ->setBillingAccountLicenseConfig($formattedBillingAccountLicenseConfig)
        ->setProjectNumber($projectNumber)
        ->setLocation($location)
        ->setLicenseCount($licenseCount);

    // Call the API and handle any network failures.
    try {
        /** @var DistributeLicenseConfigResponse $response */
        $response = $licenseConfigServiceClient->distributeLicenseConfig($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $formattedBillingAccountLicenseConfig = LicenseConfigServiceClient::billingAccountLicenseConfigName(
        '[BILLING_ACCOUNT]',
        '[BILLING_ACCOUNT_LICENSE_CONFIG]'
    );
    $projectNumber = 0;
    $location = '[LOCATION]';
    $licenseCount = 0;

    distribute_license_config_sample(
        $formattedBillingAccountLicenseConfig,
        $projectNumber,
        $location,
        $licenseCount
    );
}
// [END discoveryengine_v1_generated_LicenseConfigService_DistributeLicenseConfig_sync]
