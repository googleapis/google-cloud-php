<?php
/*
 * Copyright 2024 Google LLC
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

// [START merchantapi_v1beta_generated_PromotionsService_ListPromotions_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Shopping\Merchant\Promotions\V1beta\Client\PromotionsServiceClient;
use Google\Shopping\Merchant\Promotions\V1beta\ListPromotionsRequest;
use Google\Shopping\Merchant\Promotions\V1beta\Promotion;

/**
 * Lists the promotions in your Merchant Center account. The
 * response might contain fewer items than specified by `pageSize`. Rely on
 * `pageToken` to determine if there are more items to be requested.
 *
 * After inserting or updating a promotion, it may take several minutes before
 * the updated processed promotion can be retrieved.
 *
 * @param string $parent The account to list processed promotions for.
 *                       Format: `accounts/{account}`
 */
function list_promotions_sample(string $parent): void
{
    // Create a client.
    $promotionsServiceClient = new PromotionsServiceClient();

    // Prepare the request message.
    $request = (new ListPromotionsRequest())
        ->setParent($parent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $promotionsServiceClient->listPromotions($request);

        /** @var Promotion $element */
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

    list_promotions_sample($parent);
}
// [END merchantapi_v1beta_generated_PromotionsService_ListPromotions_sync]
