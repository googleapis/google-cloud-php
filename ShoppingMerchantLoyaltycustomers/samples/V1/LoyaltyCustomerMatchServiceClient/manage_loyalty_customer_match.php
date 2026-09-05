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

// [START merchantapi_v1_generated_LoyaltyCustomerMatchService_ManageLoyaltyCustomerMatch_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Loyaltycustomers\V1\Client\LoyaltyCustomerMatchServiceClient;
use Google\Shopping\Merchant\Loyaltycustomers\V1\LoyaltyCustomer;
use Google\Shopping\Merchant\Loyaltycustomers\V1\LoyaltyCustomer\LoyaltyTier;
use Google\Shopping\Merchant\Loyaltycustomers\V1\ManageLoyaltyCustomerMatchRequest;
use Google\Shopping\Merchant\Loyaltycustomers\V1\ManageLoyaltyCustomerMatchResponse;
use Google\Shopping\Merchant\Loyaltycustomers\V1\UserIdentifier;

/**
 * Manages (inserts, updates, or removes) a customer's loyalty tier
 * information.
 *
 * This method serves as a single interface for all changes to a customer's
 * loyalty status. The specific action (insert, update, or remove) is
 * determined by the current state of the merchant-to-customer association and
 * the `loyalty_tier` value provided in the request.
 *
 * **Operation Logic:**
 *
 * * **Upsert (Insert/Update):** Providing any valid tier other than
 * `NON_MEMBER` will associate the customer with that tier. If an association
 * already exists, it will be updated; otherwise, a new one will be created.
 * * **Removal:** Setting `loyalty_tier` to `NON_MEMBER` will remove any
 * existing loyalty association for the customer.
 *
 * **Privacy Note:** To protect user privacy, this method consistently returns
 * a `200 OK` status with a default `LoyaltyCustomer` response if the
 * customer's identifier cannot be matched to a Google account or if the user
 * has not opted into loyalty personalization.
 *
 * @param string $formattedParent            The parent account where this loyalty customer will be handled.
 *                                           Format: `accounts/{account}`
 *                                           Please see {@see LoyaltyCustomerMatchServiceClient::accountName()} for help formatting this field.
 * @param int    $loyaltyCustomerLoyaltyTier The tier label of the loyalty tier the customer belongs to.
 */
function manage_loyalty_customer_match_sample(
    string $formattedParent,
    int $loyaltyCustomerLoyaltyTier
): void {
    // Create a client.
    $loyaltyCustomerMatchServiceClient = new LoyaltyCustomerMatchServiceClient();

    // Prepare the request message.
    $loyaltyCustomerUserIdentifier = new UserIdentifier();
    $loyaltyCustomer = (new LoyaltyCustomer())
        ->setUserIdentifier($loyaltyCustomerUserIdentifier)
        ->setLoyaltyTier($loyaltyCustomerLoyaltyTier);
    $request = (new ManageLoyaltyCustomerMatchRequest())
        ->setParent($formattedParent)
        ->setLoyaltyCustomer($loyaltyCustomer);

    // Call the API and handle any network failures.
    try {
        /** @var ManageLoyaltyCustomerMatchResponse $response */
        $response = $loyaltyCustomerMatchServiceClient->manageLoyaltyCustomerMatch($request);
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
    $formattedParent = LoyaltyCustomerMatchServiceClient::accountName('[ACCOUNT]');
    $loyaltyCustomerLoyaltyTier = LoyaltyTier::LOYALTY_TIER_UNSPECIFIED;

    manage_loyalty_customer_match_sample($formattedParent, $loyaltyCustomerLoyaltyTier);
}
// [END merchantapi_v1_generated_LoyaltyCustomerMatchService_ManageLoyaltyCustomerMatch_sync]
