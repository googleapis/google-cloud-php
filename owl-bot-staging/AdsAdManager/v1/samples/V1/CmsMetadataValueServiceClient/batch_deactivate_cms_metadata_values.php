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

// [START admanager_v1_generated_CmsMetadataValueService_BatchDeactivateCmsMetadataValues_sync]
use Google\Ads\AdManager\V1\BatchDeactivateCmsMetadataValuesRequest;
use Google\Ads\AdManager\V1\BatchDeactivateCmsMetadataValuesResponse;
use Google\Ads\AdManager\V1\Client\CmsMetadataValueServiceClient;
use Google\ApiCore\ApiException;

/**
 * API to deactivate a list of `CmsMetadataValue` objects.
 *
 * @param string $formattedParent       The parent resource where `CmsMetadataValues` will be
 *                                      deactivated. Format: `networks/{network_code}`
 *                                      Please see {@see CmsMetadataValueServiceClient::networkName()} for help formatting this field.
 * @param string $formattedNamesElement The resource names of the `CmsMetadataValue`s to deactivate.
 *                                      Format:
 *                                      `networks/{network_code}/cmsMetadataValues/{cms_metadata_value_id}`
 *                                      Please see {@see CmsMetadataValueServiceClient::cmsMetadataValueName()} for help formatting this field.
 */
function batch_deactivate_cms_metadata_values_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $cmsMetadataValueServiceClient = new CmsMetadataValueServiceClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new BatchDeactivateCmsMetadataValuesRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var BatchDeactivateCmsMetadataValuesResponse $response */
        $response = $cmsMetadataValueServiceClient->batchDeactivateCmsMetadataValues($request);
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
    $formattedParent = CmsMetadataValueServiceClient::networkName('[NETWORK_CODE]');
    $formattedNamesElement = CmsMetadataValueServiceClient::cmsMetadataValueName(
        '[NETWORK_CODE]',
        '[CMS_METADATA_VALUE]'
    );

    batch_deactivate_cms_metadata_values_sample($formattedParent, $formattedNamesElement);
}
// [END admanager_v1_generated_CmsMetadataValueService_BatchDeactivateCmsMetadataValues_sync]
