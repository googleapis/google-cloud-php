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

// [START admanager_v1_generated_CdnConfigService_BatchActivateCdnConfigs_sync]
use Google\Ads\AdManager\V1\BatchActivateCdnConfigsRequest;
use Google\Ads\AdManager\V1\BatchActivateCdnConfigsResponse;
use Google\Ads\AdManager\V1\Client\CdnConfigServiceClient;
use Google\ApiCore\ApiException;

/**
 * Batch activates `CdnConfig` objects.
 *
 * @param string $formattedParent       Format: `networks/{network_code}`
 *                                      Please see {@see CdnConfigServiceClient::networkName()} for help formatting this field.
 * @param string $formattedNamesElement The resource names of the `CdnConfig` objects to activate.
 *                                      Format: `networks/{network_code}/cdnConfigs/{cdn_config_id}`
 *                                      Please see {@see CdnConfigServiceClient::cdnConfigName()} for help formatting this field.
 */
function batch_activate_cdn_configs_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $cdnConfigServiceClient = new CdnConfigServiceClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new BatchActivateCdnConfigsRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var BatchActivateCdnConfigsResponse $response */
        $response = $cdnConfigServiceClient->batchActivateCdnConfigs($request);
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
    $formattedParent = CdnConfigServiceClient::networkName('[NETWORK_CODE]');
    $formattedNamesElement = CdnConfigServiceClient::cdnConfigName('[NETWORK_CODE]', '[CDN_CONFIG]');

    batch_activate_cdn_configs_sample($formattedParent, $formattedNamesElement);
}
// [END admanager_v1_generated_CdnConfigService_BatchActivateCdnConfigs_sync]
