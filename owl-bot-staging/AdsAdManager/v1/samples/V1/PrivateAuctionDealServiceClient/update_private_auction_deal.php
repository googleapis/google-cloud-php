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

// [START admanager_v1_generated_PrivateAuctionDealService_UpdatePrivateAuctionDeal_sync]
use Google\Ads\AdManager\V1\Client\PrivateAuctionDealServiceClient;
use Google\Ads\AdManager\V1\PrivateAuctionDeal;
use Google\Ads\AdManager\V1\UpdatePrivateAuctionDealRequest;
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;
use Google\Type\Money;

/**
 * API to update a `PrivateAuctionDeal` object.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_private_auction_deal_sample(): void
{
    // Create a client.
    $privateAuctionDealServiceClient = new PrivateAuctionDealServiceClient();

    // Prepare the request message.
    $privateAuctionDealFloorPrice = new Money();
    $privateAuctionDeal = (new PrivateAuctionDeal())
        ->setFloorPrice($privateAuctionDealFloorPrice);
    $updateMask = new FieldMask();
    $request = (new UpdatePrivateAuctionDealRequest())
        ->setPrivateAuctionDeal($privateAuctionDeal)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var PrivateAuctionDeal $response */
        $response = $privateAuctionDealServiceClient->updatePrivateAuctionDeal($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END admanager_v1_generated_PrivateAuctionDealService_UpdatePrivateAuctionDeal_sync]
