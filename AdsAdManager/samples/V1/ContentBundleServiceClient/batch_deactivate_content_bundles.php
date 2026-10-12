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

// [START admanager_v1_generated_ContentBundleService_BatchDeactivateContentBundles_sync]
use Google\Ads\AdManager\V1\BatchDeactivateContentBundlesRequest;
use Google\Ads\AdManager\V1\BatchDeactivateContentBundlesResponse;
use Google\Ads\AdManager\V1\Client\ContentBundleServiceClient;
use Google\ApiCore\ApiException;

/**
 * Deactivates a list of `ContentBundle` objects.
 *
 * @param string $formattedParent       The parent resource where `ContentBundles` will be
 *                                      deactivated.
 *                                      Format: `networks/{network_code}`
 *                                      Please see {@see ContentBundleServiceClient::networkName()} for help formatting this field.
 * @param string $formattedNamesElement The resource names of the `ContentBundle`s to deactivate.
 *                                      Format: `networks/{network_code}/contentBundles/{content_bundle_id}`
 *                                      Please see {@see ContentBundleServiceClient::contentBundleName()} for help formatting this field.
 */
function batch_deactivate_content_bundles_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $contentBundleServiceClient = new ContentBundleServiceClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new BatchDeactivateContentBundlesRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var BatchDeactivateContentBundlesResponse $response */
        $response = $contentBundleServiceClient->batchDeactivateContentBundles($request);
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
    $formattedParent = ContentBundleServiceClient::networkName('[NETWORK_CODE]');
    $formattedNamesElement = ContentBundleServiceClient::contentBundleName(
        '[NETWORK_CODE]',
        '[CONTENT_BUNDLE]'
    );

    batch_deactivate_content_bundles_sample($formattedParent, $formattedNamesElement);
}
// [END admanager_v1_generated_ContentBundleService_BatchDeactivateContentBundles_sync]
