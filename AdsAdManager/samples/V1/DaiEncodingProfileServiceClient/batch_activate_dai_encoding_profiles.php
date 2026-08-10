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

// [START admanager_v1_generated_DaiEncodingProfileService_BatchActivateDaiEncodingProfiles_sync]
use Google\Ads\AdManager\V1\ActivateDaiEncodingProfileRequest;
use Google\Ads\AdManager\V1\BatchActivateDaiEncodingProfilesRequest;
use Google\Ads\AdManager\V1\BatchActivateDaiEncodingProfilesResponse;
use Google\Ads\AdManager\V1\Client\DaiEncodingProfileServiceClient;
use Google\ApiCore\ApiException;

/**
 * Activates a list of `DaiEncodingProfile` objects.
 *
 * @param string $formattedParent       Format: `networks/{network_code}`
 *                                      Please see {@see DaiEncodingProfileServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsName The resource name of the DaiEncodingProfile to activate.
 *                                      Format:
 *                                      `networks/{network_code}/daiEncodingProfiles/{dai_encoding_profile_id}`
 *                                      Please see {@see DaiEncodingProfileServiceClient::daiEncodingProfileName()} for help formatting this field.
 */
function batch_activate_dai_encoding_profiles_sample(
    string $formattedParent,
    string $formattedRequestsName
): void {
    // Create a client.
    $daiEncodingProfileServiceClient = new DaiEncodingProfileServiceClient();

    // Prepare the request message.
    $activateDaiEncodingProfileRequest = (new ActivateDaiEncodingProfileRequest())
        ->setName($formattedRequestsName);
    $requests = [$activateDaiEncodingProfileRequest,];
    $request = (new BatchActivateDaiEncodingProfilesRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchActivateDaiEncodingProfilesResponse $response */
        $response = $daiEncodingProfileServiceClient->batchActivateDaiEncodingProfiles($request);
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
    $formattedParent = DaiEncodingProfileServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsName = DaiEncodingProfileServiceClient::daiEncodingProfileName(
        '[NETWORK_CODE]',
        '[DAI_ENCODING_PROFILE]'
    );

    batch_activate_dai_encoding_profiles_sample($formattedParent, $formattedRequestsName);
}
// [END admanager_v1_generated_DaiEncodingProfileService_BatchActivateDaiEncodingProfiles_sync]
