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

// [START admanager_v1_generated_ViewabilityProviderService_BatchCreateViewabilityProviders_sync]
use Google\Ads\AdManager\V1\BatchCreateViewabilityProvidersRequest;
use Google\Ads\AdManager\V1\BatchCreateViewabilityProvidersResponse;
use Google\Ads\AdManager\V1\Client\ViewabilityProviderServiceClient;
use Google\Ads\AdManager\V1\CreateViewabilityProviderRequest;
use Google\Ads\AdManager\V1\ViewabilityProvider;
use Google\ApiCore\ApiException;

/**
 * Creates [ViewabilityProvider][google.ads.admanager.v1.ViewabilityProvider]
 * objects.
 *
 * @param string $formattedParent                                  The parent resource where
 *                                                                 [ViewabilityProvider][google.ads.admanager.v1.ViewabilityProvider]s will be
 *                                                                 created. Format: `networks/{network_code}` The parent field in the
 *                                                                 CreateViewabilityProviderRequest must match this field. Please see
 *                                                                 {@see ViewabilityProviderServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsParent                          The parent resource where this
 *                                                                 [ViewabilityProvider][google.ads.admanager.v1.ViewabilityProvider] will be
 *                                                                 created. Format: `networks/{network_code}`
 *                                                                 Please see {@see ViewabilityProviderServiceClient::networkName()} for help formatting this field.
 * @param string $requestsViewabilityProviderDisplayName           The display name of the
 *                                                                 [ViewabilityProvider][google.ads.admanager.v1.ViewabilityProvider].
 * @param string $requestsViewabilityProviderVendorKey             The key for the
 *                                                                 [ViewabilityProvider][google.ads.admanager.v1.ViewabilityProvider].
 * @param string $requestsViewabilityProviderVerificationScriptUrl The URL that hosts the verification script for the
 *                                                                 [ViewabilityProvider][google.ads.admanager.v1.ViewabilityProvider].
 */
function batch_create_viewability_providers_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $requestsViewabilityProviderDisplayName,
    string $requestsViewabilityProviderVendorKey,
    string $requestsViewabilityProviderVerificationScriptUrl
): void {
    // Create a client.
    $viewabilityProviderServiceClient = new ViewabilityProviderServiceClient();

    // Prepare the request message.
    $requestsViewabilityProvider = (new ViewabilityProvider())
        ->setDisplayName($requestsViewabilityProviderDisplayName)
        ->setVendorKey($requestsViewabilityProviderVendorKey)
        ->setVerificationScriptUrl($requestsViewabilityProviderVerificationScriptUrl);
    $createViewabilityProviderRequest = (new CreateViewabilityProviderRequest())
        ->setParent($formattedRequestsParent)
        ->setViewabilityProvider($requestsViewabilityProvider);
    $requests = [$createViewabilityProviderRequest,];
    $request = (new BatchCreateViewabilityProvidersRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateViewabilityProvidersResponse $response */
        $response = $viewabilityProviderServiceClient->batchCreateViewabilityProviders($request);
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
    $formattedParent = ViewabilityProviderServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsParent = ViewabilityProviderServiceClient::networkName('[NETWORK_CODE]');
    $requestsViewabilityProviderDisplayName = '[DISPLAY_NAME]';
    $requestsViewabilityProviderVendorKey = '[VENDOR_KEY]';
    $requestsViewabilityProviderVerificationScriptUrl = '[VERIFICATION_SCRIPT_URL]';

    batch_create_viewability_providers_sample(
        $formattedParent,
        $formattedRequestsParent,
        $requestsViewabilityProviderDisplayName,
        $requestsViewabilityProviderVendorKey,
        $requestsViewabilityProviderVerificationScriptUrl
    );
}
// [END admanager_v1_generated_ViewabilityProviderService_BatchCreateViewabilityProviders_sync]
