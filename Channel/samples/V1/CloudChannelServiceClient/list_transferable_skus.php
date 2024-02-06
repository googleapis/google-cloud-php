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

// [START cloudchannel_v1_generated_CloudChannelService_ListTransferableSkus_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\ListTransferableSkusRequest;
use Google\Cloud\Channel\V1\TransferableSku;

/**
 * List [TransferableSku][google.cloud.channel.v1.TransferableSku]s of a
 * customer based on the Cloud Identity ID or Customer Name in the request.
 *
 * Use this method to list the entitlements information of an
 * unowned customer. You should provide the customer's
 * Cloud Identity ID or Customer Name.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED:
 * * The customer doesn't belong to the reseller and has no auth token.
 * * The supplied auth token is invalid.
 * * The reseller account making the request is different
 * from the reseller account in the query.
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 *
 * Return value:
 * A list of the customer's
 * [TransferableSku][google.cloud.channel.v1.TransferableSku].
 *
 * @param string $parent The reseller account's resource name.
 *                       Parent uses the format: accounts/{account_id}
 */
function list_transferable_skus_sample(string $parent): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $request = (new ListTransferableSkusRequest())
        ->setParent($parent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $cloudChannelServiceClient->listTransferableSkus($request);

        /** @var TransferableSku $element */
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

    list_transferable_skus_sample($parent);
}
// [END cloudchannel_v1_generated_CloudChannelService_ListTransferableSkus_sync]
