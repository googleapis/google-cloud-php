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

// [START cloudchannel_v1_generated_CloudChannelService_ListSkuGroups_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\SkuGroup;

/**
 * Lists the Rebilling supported SKU groups the account is authorized to
 * sell.
 * Reference: https://cloud.google.com/skus/sku-groups
 *
 * Possible Error Codes:
 *
 * * PERMISSION_DENIED: If the account making the request and the account
 * being queried are different, or the account doesn't exist.
 * * INTERNAL: Any non-user error related to technical issues in the
 * backend. In this case, contact Cloud Channel support.
 *
 * Return Value:
 * If successful, the [SkuGroup][google.cloud.channel.v1.SkuGroup] resources.
 * The data for each resource is displayed in the alphabetical order of SKU
 * group display name.
 * The data for each resource is displayed in the ascending order of
 * [SkuGroup.display_name][google.cloud.channel.v1.SkuGroup.display_name]
 *
 * If unsuccessful, returns an error.
 *
 * @param string $parent The resource name of the account from which to list SKU groups.
 *                       Parent uses the format: accounts/{account}.
 */
function list_sku_groups_sample(string $parent): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $cloudChannelServiceClient->listSkuGroups($parent);

        /** @var SkuGroup $element */
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

    list_sku_groups_sample($parent);
}
// [END cloudchannel_v1_generated_CloudChannelService_ListSkuGroups_sync]
