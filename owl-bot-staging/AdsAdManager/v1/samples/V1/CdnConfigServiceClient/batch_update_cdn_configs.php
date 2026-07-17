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

// [START admanager_v1_generated_CdnConfigService_BatchUpdateCdnConfigs_sync]
use Google\Ads\AdManager\V1\BatchUpdateCdnConfigsRequest;
use Google\Ads\AdManager\V1\BatchUpdateCdnConfigsResponse;
use Google\Ads\AdManager\V1\CdnConfig;
use Google\Ads\AdManager\V1\CdnConfigTypeEnum\CdnConfigType;
use Google\Ads\AdManager\V1\Client\CdnConfigServiceClient;
use Google\Ads\AdManager\V1\UpdateCdnConfigRequest;
use Google\ApiCore\ApiException;

/**
 * Batch updates `CdnConfig` objects.
 *
 * @param string $formattedParent                The parent resource where `CdnConfigs` will be updated.
 *                                               Format: `networks/{network_code}`
 *                                               The parent field in the UpdateCdnConfigRequest must match this
 *                                               field. Please see
 *                                               {@see CdnConfigServiceClient::networkName()} for help formatting this field.
 * @param string $requestsCdnConfigDisplayName   The name of the CdnConfig. This value is required to create a CDN
 *                                               config and has a maximum length of 255 characters.
 * @param int    $requestsCdnConfigCdnConfigType The type of CDN config represented by this CdnConfig.
 */
function batch_update_cdn_configs_sample(
    string $formattedParent,
    string $requestsCdnConfigDisplayName,
    int $requestsCdnConfigCdnConfigType
): void {
    // Create a client.
    $cdnConfigServiceClient = new CdnConfigServiceClient();

    // Prepare the request message.
    $requestsCdnConfig = (new CdnConfig())
        ->setDisplayName($requestsCdnConfigDisplayName)
        ->setCdnConfigType($requestsCdnConfigCdnConfigType);
    $updateCdnConfigRequest = (new UpdateCdnConfigRequest())
        ->setCdnConfig($requestsCdnConfig);
    $requests = [$updateCdnConfigRequest,];
    $request = (new BatchUpdateCdnConfigsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateCdnConfigsResponse $response */
        $response = $cdnConfigServiceClient->batchUpdateCdnConfigs($request);
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
    $requestsCdnConfigDisplayName = '[DISPLAY_NAME]';
    $requestsCdnConfigCdnConfigType = CdnConfigType::CDN_CONFIG_TYPE_UNSPECIFIED;

    batch_update_cdn_configs_sample(
        $formattedParent,
        $requestsCdnConfigDisplayName,
        $requestsCdnConfigCdnConfigType
    );
}
// [END admanager_v1_generated_CdnConfigService_BatchUpdateCdnConfigs_sync]
