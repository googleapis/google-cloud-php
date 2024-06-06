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

// [START merchantapi_v1beta_generated_ShippingSettingsService_InsertShippingSettings_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1beta\Client\ShippingSettingsServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\InsertShippingSettingsRequest;
use Google\Shopping\Merchant\Accounts\V1beta\ShippingSettings;

/**
 * Replace the shipping setting of a merchant with the request shipping
 * setting. Executing this method requires admin access.
 *
 * @param string $parent              The account where this product will be inserted.
 *                                    Format: accounts/{account}
 * @param string $shippingSettingEtag This field is used for avoid async issue. Make sure shipping
 *                                    setting data
 *                                    didn't change between get call and insert call. The user should do
 *                                    following steps：
 *
 *                                    1. Set etag field as empty string for initial shipping setting creation.
 *
 *                                    2. After initial creation, call get method to obtain an etag and current
 *                                    shipping setting data before call insert.
 *
 *                                    3. Modify to wanted shipping setting information.
 *
 *                                    4. Call insert method with the wanted shipping setting information with
 *                                    the etag obtained from step 2.
 *
 *                                    5. If shipping setting data changed between step 2 and step 4. Insert
 *                                    request will fail because the etag changes every time the shipping setting
 *                                    data changes. User should repeate step 2-4 with the new etag.
 */
function insert_shipping_settings_sample(string $parent, string $shippingSettingEtag): void
{
    // Create a client.
    $shippingSettingsServiceClient = new ShippingSettingsServiceClient();

    // Prepare the request message.
    $shippingSetting = (new ShippingSettings())
        ->setEtag($shippingSettingEtag);
    $request = (new InsertShippingSettingsRequest())
        ->setParent($parent)
        ->setShippingSetting($shippingSetting);

    // Call the API and handle any network failures.
    try {
        /** @var ShippingSettings $response */
        $response = $shippingSettingsServiceClient->insertShippingSettings($request);
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
    $parent = '[PARENT]';
    $shippingSettingEtag = '[ETAG]';

    insert_shipping_settings_sample($parent, $shippingSettingEtag);
}
// [END merchantapi_v1beta_generated_ShippingSettingsService_InsertShippingSettings_sync]
