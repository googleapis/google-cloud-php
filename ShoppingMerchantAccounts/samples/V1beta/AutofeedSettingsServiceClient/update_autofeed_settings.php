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

// [START merchantapi_v1beta_generated_AutofeedSettingsService_UpdateAutofeedSettings_sync]
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;
use Google\Shopping\Merchant\Accounts\V1beta\AutofeedSettings;
use Google\Shopping\Merchant\Accounts\V1beta\Client\AutofeedSettingsServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\UpdateAutofeedSettingsRequest;

/**
 * Updates the autofeed settings of an account.
 *
 * @param bool $autofeedSettingsEnableProducts Enables or disables product crawling through the autofeed for the
 *                                             given account. Autofeed accounts must meet [certain
 *                                             conditions](https://support.google.com/merchants/answer/7538732#Configure_automated_feeds_Standard_Experience),
 *                                             which can be checked through the `eligible` field.
 *                                             The account must **not** be a marketplace.
 *                                             When the autofeed is enabled for the first time, the products usually
 *                                             appear instantly. When re-enabling, it might take up to 24 hours for
 *                                             products to appear.
 */
function update_autofeed_settings_sample(bool $autofeedSettingsEnableProducts): void
{
    // Create a client.
    $autofeedSettingsServiceClient = new AutofeedSettingsServiceClient();

    // Prepare the request message.
    $autofeedSettings = (new AutofeedSettings())
        ->setEnableProducts($autofeedSettingsEnableProducts);
    $updateMask = new FieldMask();
    $request = (new UpdateAutofeedSettingsRequest())
        ->setAutofeedSettings($autofeedSettings)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var AutofeedSettings $response */
        $response = $autofeedSettingsServiceClient->updateAutofeedSettings($request);
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
    $autofeedSettingsEnableProducts = false;

    update_autofeed_settings_sample($autofeedSettingsEnableProducts);
}
// [END merchantapi_v1beta_generated_AutofeedSettingsService_UpdateAutofeedSettings_sync]
