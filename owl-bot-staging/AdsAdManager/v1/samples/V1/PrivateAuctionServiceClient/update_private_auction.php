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

// [START admanager_v1_generated_PrivateAuctionService_UpdatePrivateAuction_sync]
use Google\Ads\AdManager\V1\Client\PrivateAuctionServiceClient;
use Google\Ads\AdManager\V1\PrivateAuction;
use Google\Ads\AdManager\V1\UpdatePrivateAuctionRequest;
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;

/**
 * API to update a `PrivateAuction` object.
 *
 * @param string $privateAuctionDisplayName Display name of the `PrivateAuction`. This attribute has a
 *                                          maximum length of 255 bytes.
 */
function update_private_auction_sample(string $privateAuctionDisplayName): void
{
    // Create a client.
    $privateAuctionServiceClient = new PrivateAuctionServiceClient();

    // Prepare the request message.
    $privateAuction = (new PrivateAuction())
        ->setDisplayName($privateAuctionDisplayName);
    $updateMask = new FieldMask();
    $request = (new UpdatePrivateAuctionRequest())
        ->setPrivateAuction($privateAuction)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var PrivateAuction $response */
        $response = $privateAuctionServiceClient->updatePrivateAuction($request);
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
    $privateAuctionDisplayName = '[DISPLAY_NAME]';

    update_private_auction_sample($privateAuctionDisplayName);
}
// [END admanager_v1_generated_PrivateAuctionService_UpdatePrivateAuction_sync]
