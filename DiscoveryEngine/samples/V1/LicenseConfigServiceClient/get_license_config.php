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

// [START discoveryengine_v1_generated_LicenseConfigService_GetLicenseConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\LicenseConfigServiceClient;
use Google\Cloud\DiscoveryEngine\V1\GetLicenseConfigRequest;
use Google\Cloud\DiscoveryEngine\V1\LicenseConfig;

/**
 * Gets a [LicenseConfig][google.cloud.discoveryengine.v1.LicenseConfig].
 *
 * @param string $formattedName Full resource name of
 *                              [LicenseConfig][google.cloud.discoveryengine.v1.LicenseConfig], such as
 *                              `projects/{project}/locations/{location}/licenseConfigs/*`.
 *
 *                              If the caller does not have permission to access the
 *                              [LicenseConfig][google.cloud.discoveryengine.v1.LicenseConfig], regardless
 *                              of whether or not it exists, a PERMISSION_DENIED error is returned.
 *
 *                              If the requested
 *                              [LicenseConfig][google.cloud.discoveryengine.v1.LicenseConfig] does not
 *                              exist, a NOT_FOUND error is returned. Please see
 *                              {@see LicenseConfigServiceClient::licenseConfigName()} for help formatting this field.
 */
function get_license_config_sample(string $formattedName): void
{
    // Create a client.
    $licenseConfigServiceClient = new LicenseConfigServiceClient();

    // Prepare the request message.
    $request = (new GetLicenseConfigRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var LicenseConfig $response */
        $response = $licenseConfigServiceClient->getLicenseConfig($request);
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
    $formattedName = LicenseConfigServiceClient::licenseConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[LICENSE_CONFIG]'
    );

    get_license_config_sample($formattedName);
}
// [END discoveryengine_v1_generated_LicenseConfigService_GetLicenseConfig_sync]
