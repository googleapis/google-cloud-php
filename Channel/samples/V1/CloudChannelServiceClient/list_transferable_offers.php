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

// [START cloudchannel_v1_generated_CloudChannelService_ListTransferableOffers_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\ListTransferableOffersRequest;
use Google\Cloud\Channel\V1\TransferableOffer;

/**
 * List [TransferableOffer][google.cloud.channel.v1.TransferableOffer]s of a
 * customer based on Cloud Identity ID or Customer Name in the request.
 *
 * Use this method when a reseller gets the entitlement information of an
 * unowned customer. The reseller should provide the customer's
 * Cloud Identity ID or Customer Name.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED:
 * * The customer doesn't belong to the reseller and has no auth token.
 * * The customer provided incorrect reseller information when generating
 * auth token.
 * * The reseller account making the request is different
 * from the reseller account in the query.
 * * The reseller is not authorized to transact on this Product. See
 * https://support.google.com/channelservices/answer/9759265
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 *
 * Return value:
 * List of [TransferableOffer][google.cloud.channel.v1.TransferableOffer] for
 * the given customer and SKU.
 *
 * @param string $parent The resource name of the reseller's account.
 * @param string $sku    The SKU to look up Offers for.
 */
function list_transferable_offers_sample(string $parent, string $sku): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $request = (new ListTransferableOffersRequest())
        ->setParent($parent)
        ->setSku($sku);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $cloudChannelServiceClient->listTransferableOffers($request);

        /** @var TransferableOffer $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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
    $parent = '[PARENT]';
    $sku = '[SKU]';

    list_transferable_offers_sample($parent, $sku);
}
// [END cloudchannel_v1_generated_CloudChannelService_ListTransferableOffers_sync]
