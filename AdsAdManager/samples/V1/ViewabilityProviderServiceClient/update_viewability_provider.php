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

// [START admanager_v1_generated_ViewabilityProviderService_UpdateViewabilityProvider_sync]
use Google\Ads\AdManager\V1\Client\ViewabilityProviderServiceClient;
use Google\Ads\AdManager\V1\UpdateViewabilityProviderRequest;
use Google\Ads\AdManager\V1\ViewabilityProvider;
use Google\ApiCore\ApiException;

/**
 * Updates a
 * [ViewabilityProvider][google.ads.admanager.v1.ViewabilityProvider] object.
 *
 * @param string $viewabilityProviderDisplayName           The display name of the
 *                                                         [ViewabilityProvider][google.ads.admanager.v1.ViewabilityProvider].
 * @param string $viewabilityProviderVendorKey             The key for the
 *                                                         [ViewabilityProvider][google.ads.admanager.v1.ViewabilityProvider].
 * @param string $viewabilityProviderVerificationScriptUrl The URL that hosts the verification script for the
 *                                                         [ViewabilityProvider][google.ads.admanager.v1.ViewabilityProvider].
 */
function update_viewability_provider_sample(
    string $viewabilityProviderDisplayName,
    string $viewabilityProviderVendorKey,
    string $viewabilityProviderVerificationScriptUrl
): void {
    // Create a client.
    $viewabilityProviderServiceClient = new ViewabilityProviderServiceClient();

    // Prepare the request message.
    $viewabilityProvider = (new ViewabilityProvider())
        ->setDisplayName($viewabilityProviderDisplayName)
        ->setVendorKey($viewabilityProviderVendorKey)
        ->setVerificationScriptUrl($viewabilityProviderVerificationScriptUrl);
    $request = (new UpdateViewabilityProviderRequest())
        ->setViewabilityProvider($viewabilityProvider);

    // Call the API and handle any network failures.
    try {
        /** @var ViewabilityProvider $response */
        $response = $viewabilityProviderServiceClient->updateViewabilityProvider($request);
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
    $viewabilityProviderDisplayName = '[DISPLAY_NAME]';
    $viewabilityProviderVendorKey = '[VENDOR_KEY]';
    $viewabilityProviderVerificationScriptUrl = '[VERIFICATION_SCRIPT_URL]';

    update_viewability_provider_sample(
        $viewabilityProviderDisplayName,
        $viewabilityProviderVendorKey,
        $viewabilityProviderVerificationScriptUrl
    );
}
// [END admanager_v1_generated_ViewabilityProviderService_UpdateViewabilityProvider_sync]
