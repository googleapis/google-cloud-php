<?php
/*
 * Copyright 2022 Google LLC
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

// [START websecurityscanner_v1beta_generated_WebSecurityScanner_UpdateScanConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\WebSecurityScanner\V1beta\ScanConfig;
use Google\Cloud\WebSecurityScanner\V1beta\WebSecurityScannerClient;
use Google\Protobuf\FieldMask;

/**
 * Updates a ScanConfig. This method support partial update of a ScanConfig.
 *
 * @param string $scanConfigDisplayName         The user provided display name of the ScanConfig.
 * @param string $scanConfigStartingUrlsElement The starting URLs from which the scanner finds site pages.
 */
function update_scan_config_sample(
    string $scanConfigDisplayName,
    string $scanConfigStartingUrlsElement
): void {
    // Create a client.
    $webSecurityScannerClient = new WebSecurityScannerClient();

    // Prepare the request message.
    $scanConfigStartingUrls = [$scanConfigStartingUrlsElement,];
    $scanConfig = (new ScanConfig())
        ->setDisplayName($scanConfigDisplayName)
        ->setStartingUrls($scanConfigStartingUrls);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var ScanConfig $response */
        $response = $webSecurityScannerClient->updateScanConfig($scanConfig, $updateMask);
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
    $scanConfigDisplayName = '[DISPLAY_NAME]';
    $scanConfigStartingUrlsElement = '[STARTING_URLS]';

    update_scan_config_sample($scanConfigDisplayName, $scanConfigStartingUrlsElement);
}
// [END websecurityscanner_v1beta_generated_WebSecurityScanner_UpdateScanConfig_sync]
