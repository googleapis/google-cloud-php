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

// [START discoveryengine_v1_generated_LicenseConfigService_UpdateLicenseConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\LicenseConfigServiceClient;
use Google\Cloud\DiscoveryEngine\V1\LicenseConfig;
use Google\Cloud\DiscoveryEngine\V1\SubscriptionTerm;
use Google\Cloud\DiscoveryEngine\V1\SubscriptionTier;
use Google\Cloud\DiscoveryEngine\V1\UpdateLicenseConfigRequest;
use Google\Type\Date;

/**
 * Updates the [LicenseConfig][google.cloud.discoveryengine.v1.LicenseConfig]
 *
 * @param int $licenseConfigLicenseCount     Number of licenses purchased.
 * @param int $licenseConfigSubscriptionTier Subscription tier information for the license config.
 * @param int $licenseConfigSubscriptionTerm Subscription term.
 */
function update_license_config_sample(
    int $licenseConfigLicenseCount,
    int $licenseConfigSubscriptionTier,
    int $licenseConfigSubscriptionTerm
): void {
    // Create a client.
    $licenseConfigServiceClient = new LicenseConfigServiceClient();

    // Prepare the request message.
    $licenseConfigStartDate = new Date();
    $licenseConfig = (new LicenseConfig())
        ->setLicenseCount($licenseConfigLicenseCount)
        ->setSubscriptionTier($licenseConfigSubscriptionTier)
        ->setStartDate($licenseConfigStartDate)
        ->setSubscriptionTerm($licenseConfigSubscriptionTerm);
    $request = (new UpdateLicenseConfigRequest())
        ->setLicenseConfig($licenseConfig);

    // Call the API and handle any network failures.
    try {
        /** @var LicenseConfig $response */
        $response = $licenseConfigServiceClient->updateLicenseConfig($request);
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
    $licenseConfigLicenseCount = 0;
    $licenseConfigSubscriptionTier = SubscriptionTier::SUBSCRIPTION_TIER_UNSPECIFIED;
    $licenseConfigSubscriptionTerm = SubscriptionTerm::SUBSCRIPTION_TERM_UNSPECIFIED;

    update_license_config_sample(
        $licenseConfigLicenseCount,
        $licenseConfigSubscriptionTier,
        $licenseConfigSubscriptionTerm
    );
}
// [END discoveryengine_v1_generated_LicenseConfigService_UpdateLicenseConfig_sync]
