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

// [START admanager_v1_generated_PrivateAuctionDealService_CreatePrivateAuctionDeal_sync]
use Google\Ads\AdManager\V1\Client\PrivateAuctionDealServiceClient;
use Google\Ads\AdManager\V1\CreatePrivateAuctionDealRequest;
use Google\Ads\AdManager\V1\PrivateAuctionDeal;
use Google\ApiCore\ApiException;
use Google\Type\Money;

/**
 * API to create a `PrivateAuctionDeal` object.
 *
 * @param string $formattedParent The parent resource where this `PrivateAuctionDeal` will be
 *                                created. Format: `networks/{network_code}`
 *                                Please see {@see PrivateAuctionDealServiceClient::networkName()} for help formatting this field.
 */
function create_private_auction_deal_sample(string $formattedParent): void
{
    // Create a client.
    $privateAuctionDealServiceClient = new PrivateAuctionDealServiceClient();

    // Prepare the request message.
    $privateAuctionDealFloorPrice = new Money();
    $privateAuctionDeal = (new PrivateAuctionDeal())
        ->setFloorPrice($privateAuctionDealFloorPrice);
    $request = (new CreatePrivateAuctionDealRequest())
        ->setParent($formattedParent)
        ->setPrivateAuctionDeal($privateAuctionDeal);

    // Call the API and handle any network failures.
    try {
        /** @var PrivateAuctionDeal $response */
        $response = $privateAuctionDealServiceClient->createPrivateAuctionDeal($request);
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
    $formattedParent = PrivateAuctionDealServiceClient::networkName('[NETWORK_CODE]');

    create_private_auction_deal_sample($formattedParent);
}
// [END admanager_v1_generated_PrivateAuctionDealService_CreatePrivateAuctionDeal_sync]
