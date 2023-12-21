<?php
/*
 * Copyright 2023 Google LLC
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

// [START cloudchannel_v1_generated_CloudChannelService_LookupOffer_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\Offer;

/**
 * Returns the requested [Offer][google.cloud.channel.v1.Offer] resource.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The entitlement doesn't belong to the reseller.
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 * * NOT_FOUND: Entitlement or offer was not found.
 *
 * Return value:
 * The [Offer][google.cloud.channel.v1.Offer] resource.
 *
 * @param string $formattedEntitlement The resource name of the entitlement to retrieve the Offer.
 *                                     Entitlement uses the format:
 *                                     accounts/{account_id}/customers/{customer_id}/entitlements/{entitlement_id}
 *                                     Please see {@see CloudChannelServiceClient::entitlementName()} for help formatting this field.
 */
function lookup_offer_sample(string $formattedEntitlement): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var Offer $response */
        $response = $cloudChannelServiceClient->lookupOffer($formattedEntitlement);
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
    $formattedEntitlement = CloudChannelServiceClient::entitlementName(
        '[ACCOUNT]',
        '[CUSTOMER]',
        '[ENTITLEMENT]'
    );

    lookup_offer_sample($formattedEntitlement);
}
// [END cloudchannel_v1_generated_CloudChannelService_LookupOffer_sync]
