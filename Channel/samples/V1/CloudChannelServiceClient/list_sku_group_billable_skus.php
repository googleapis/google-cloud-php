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

// [START cloudchannel_v1_generated_CloudChannelService_ListSkuGroupBillableSkus_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Channel\V1\BillableSku;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\ListSkuGroupBillableSkusRequest;

/**
 * Lists the Billable SKUs in a given SKU group.
 *
 * Possible error codes:
 * PERMISSION_DENIED: If the account making the request and the account
 * being queried for are different, or the account doesn't exist.
 * INVALID_ARGUMENT: Missing or invalid required parameters in the
 * request.
 * INTERNAL: Any non-user error related to technical issue in the
 * backend. In this case, contact cloud channel support.
 *
 * Return Value:
 * If successful, the [BillableSku][google.cloud.channel.v1.BillableSku]
 * resources. The data for each resource is displayed in the ascending order
 * of:
 *
 * * [BillableSku.service_display_name][google.cloud.channel.v1.BillableSku.service_display_name]
 * * [BillableSku.sku_display_name][google.cloud.channel.v1.BillableSku.sku_display_name]
 *
 * If unsuccessful, returns an error.
 *
 * @param string $formattedParent Resource name of the SKU group.
 *                                Format: accounts/{account}/skuGroups/{sku_group}. Please see
 *                                {@see CloudChannelServiceClient::skuGroupName()} for help formatting this field.
 */
function list_sku_group_billable_skus_sample(string $formattedParent): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $request = (new ListSkuGroupBillableSkusRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $cloudChannelServiceClient->listSkuGroupBillableSkus($request);

        /** @var BillableSku $element */
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
    $formattedParent = CloudChannelServiceClient::skuGroupName('[ACCOUNT]', '[SKU_GROUP]');

    list_sku_group_billable_skus_sample($formattedParent);
}
// [END cloudchannel_v1_generated_CloudChannelService_ListSkuGroupBillableSkus_sync]
