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

// [START merchantapi_v1_generated_ShippingSettingsService_InsertShippingSettings_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1\Client\ShippingSettingsServiceClient;
use Google\Shopping\Merchant\Accounts\V1\InsertShippingSettingsRequest;
use Google\Shopping\Merchant\Accounts\V1\ShippingSettings;

/**
 * Replace the shipping setting of a business with the request shipping
 * setting. Executing this method requires admin access.
 *
 * @param string $formattedParent     The account for which this shipping setting will be inserted. If
 *                                    you are using an advanced account, you must specify the unique identifier
 *                                    of the sub-account for which you want to insert the shipping setting.
 *                                    Format: `accounts/{ACCOUNT_ID}`
 *                                    Please see {@see ShippingSettingsServiceClient::accountName()} for help formatting this field.
 * @param string $shippingSettingEtag This field helps avoid async issues. It ensures that the shipping
 *                                    setting
 *                                    data doesn't change between the `get` call and the `insert` call. The user
 *                                    should follow these steps:
 *
 *                                    1. Set the etag field as an empty string for the initial shipping setting
 *                                    creation.
 *
 *                                    2. After the initial creation, call the `get` method to obtain an etag and
 *                                    the current shipping setting data before calling `insert`.
 *
 *                                    3. Modify the shipping setting information.
 *
 *                                    4. Call the `insert` method with the shipping setting information
 *                                    and the etag obtained in step 2.
 *
 *                                    5. If the shipping setting data changes between step 2 and step 4, the
 *                                    insert request will fail because the etag changes every time the shipping
 *                                    setting data changes. In this case, the user should repeat steps 2-4 with
 *                                    the new etag.
 */
function insert_shipping_settings_sample(
    string $formattedParent,
    string $shippingSettingEtag
): void {
    // Create a client.
    $shippingSettingsServiceClient = new ShippingSettingsServiceClient();

    // Prepare the request message.
    $shippingSetting = (new ShippingSettings())
        ->setEtag($shippingSettingEtag);
    $request = (new InsertShippingSettingsRequest())
        ->setParent($formattedParent)
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
    $formattedParent = ShippingSettingsServiceClient::accountName('[ACCOUNT]');
    $shippingSettingEtag = '[ETAG]';

    insert_shipping_settings_sample($formattedParent, $shippingSettingEtag);
}
// [END merchantapi_v1_generated_ShippingSettingsService_InsertShippingSettings_sync]
