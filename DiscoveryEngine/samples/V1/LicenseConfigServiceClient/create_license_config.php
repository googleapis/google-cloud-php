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

// [START discoveryengine_v1_generated_LicenseConfigService_CreateLicenseConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\LicenseConfigServiceClient;
use Google\Cloud\DiscoveryEngine\V1\CreateLicenseConfigRequest;
use Google\Cloud\DiscoveryEngine\V1\LicenseConfig;
use Google\Cloud\DiscoveryEngine\V1\SubscriptionTerm;
use Google\Cloud\DiscoveryEngine\V1\SubscriptionTier;
use Google\Type\Date;

/**
 * Creates a [LicenseConfig][google.cloud.discoveryengine.v1.LicenseConfig]
 * This method should only be used for creating NotebookLm licenses or Gemini
 * Enterprise free trial licenses.
 *
 * @param string $formattedParent               The parent resource name, such as
 *                                              `projects/{project}/locations/{location}`. Please see
 *                                              {@see LicenseConfigServiceClient::locationName()} for help formatting this field.
 * @param int    $licenseConfigLicenseCount     Number of licenses purchased.
 * @param int    $licenseConfigSubscriptionTier Subscription tier information for the license config.
 * @param int    $licenseConfigSubscriptionTerm Subscription term.
 */
function create_license_config_sample(
    string $formattedParent,
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
    $request = (new CreateLicenseConfigRequest())
        ->setParent($formattedParent)
        ->setLicenseConfig($licenseConfig);

    // Call the API and handle any network failures.
    try {
        /** @var LicenseConfig $response */
        $response = $licenseConfigServiceClient->createLicenseConfig($request);
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
    $formattedParent = LicenseConfigServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $licenseConfigLicenseCount = 0;
    $licenseConfigSubscriptionTier = SubscriptionTier::SUBSCRIPTION_TIER_UNSPECIFIED;
    $licenseConfigSubscriptionTerm = SubscriptionTerm::SUBSCRIPTION_TERM_UNSPECIFIED;

    create_license_config_sample(
        $formattedParent,
        $licenseConfigLicenseCount,
        $licenseConfigSubscriptionTier,
        $licenseConfigSubscriptionTerm
    );
}
// [END discoveryengine_v1_generated_LicenseConfigService_CreateLicenseConfig_sync]
