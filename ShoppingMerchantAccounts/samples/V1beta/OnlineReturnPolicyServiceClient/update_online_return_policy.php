<?php
/*
 * Copyright 2025 Google LLC
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

// [START merchantapi_v1beta_generated_OnlineReturnPolicyService_UpdateOnlineReturnPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1beta\Client\OnlineReturnPolicyServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\OnlineReturnPolicy;
use Google\Shopping\Merchant\Accounts\V1beta\UpdateOnlineReturnPolicyRequest;

/**
 * Updates an existing return policy for a given merchant.
 *
 * @param string $onlineReturnPolicyLabel            Immutable. This field represents the unique user-defined label of
 *                                                   the return policy. It is important to note that the same label cannot be
 *                                                   used in different return policies for the same country. Unless a product
 *                                                   specifies a specific label attribute, policies will be automatically
 *                                                   labeled as 'default'. To assign a custom return policy to certain product
 *                                                   groups, follow the instructions provided in the [Return policy label]
 *                                                   (https://support.google.com/merchants/answer/9445425).
 *                                                   The label can contain up to 50 characters.
 * @param string $onlineReturnPolicyCountriesElement Immutable. The countries of sale where the return policy applies.
 *                                                   The values must be a valid 2 letter ISO 3166 code.
 * @param string $onlineReturnPolicyReturnPolicyUri  The return policy uri. This can used by Google to do a sanity
 *                                                   check for the policy. It must be a valid URL.
 */
function update_online_return_policy_sample(
    string $onlineReturnPolicyLabel,
    string $onlineReturnPolicyCountriesElement,
    string $onlineReturnPolicyReturnPolicyUri
): void {
    // Create a client.
    $onlineReturnPolicyServiceClient = new OnlineReturnPolicyServiceClient();

    // Prepare the request message.
    $onlineReturnPolicyCountries = [$onlineReturnPolicyCountriesElement,];
    $onlineReturnPolicy = (new OnlineReturnPolicy())
        ->setLabel($onlineReturnPolicyLabel)
        ->setCountries($onlineReturnPolicyCountries)
        ->setReturnPolicyUri($onlineReturnPolicyReturnPolicyUri);
    $request = (new UpdateOnlineReturnPolicyRequest())
        ->setOnlineReturnPolicy($onlineReturnPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OnlineReturnPolicy $response */
        $response = $onlineReturnPolicyServiceClient->updateOnlineReturnPolicy($request);
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
    $onlineReturnPolicyLabel = '[LABEL]';
    $onlineReturnPolicyCountriesElement = '[COUNTRIES]';
    $onlineReturnPolicyReturnPolicyUri = '[RETURN_POLICY_URI]';

    update_online_return_policy_sample(
        $onlineReturnPolicyLabel,
        $onlineReturnPolicyCountriesElement,
        $onlineReturnPolicyReturnPolicyUri
    );
}
// [END merchantapi_v1beta_generated_OnlineReturnPolicyService_UpdateOnlineReturnPolicy_sync]
