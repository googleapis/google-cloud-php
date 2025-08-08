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

// [START merchantapi_v1_generated_OmnichannelSettingsService_CreateOmnichannelSetting_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1\Client\OmnichannelSettingsServiceClient;
use Google\Shopping\Merchant\Accounts\V1\CreateOmnichannelSettingRequest;
use Google\Shopping\Merchant\Accounts\V1\OmnichannelSetting;
use Google\Shopping\Merchant\Accounts\V1\OmnichannelSetting\LsfType;

/**
 * Create the omnichannel settings for a given merchant.
 *
 * @param string $formattedParent              The parent resource where this omnichannel setting will be
 *                                             created. Format: `accounts/{account}`
 *                                             Please see {@see OmnichannelSettingsServiceClient::accountName()} for help formatting this field.
 * @param string $omnichannelSettingRegionCode Immutable. Region code defined by
 *                                             [CLDR](https://cldr.unicode.org/). Must be provided in the Create method,
 *                                             and is immutable.
 * @param int    $omnichannelSettingLsfType    The Local Store Front type for this country.
 */
function create_omnichannel_setting_sample(
    string $formattedParent,
    string $omnichannelSettingRegionCode,
    int $omnichannelSettingLsfType
): void {
    // Create a client.
    $omnichannelSettingsServiceClient = new OmnichannelSettingsServiceClient();

    // Prepare the request message.
    $omnichannelSetting = (new OmnichannelSetting())
        ->setRegionCode($omnichannelSettingRegionCode)
        ->setLsfType($omnichannelSettingLsfType);
    $request = (new CreateOmnichannelSettingRequest())
        ->setParent($formattedParent)
        ->setOmnichannelSetting($omnichannelSetting);

    // Call the API and handle any network failures.
    try {
        /** @var OmnichannelSetting $response */
        $response = $omnichannelSettingsServiceClient->createOmnichannelSetting($request);
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
    $formattedParent = OmnichannelSettingsServiceClient::accountName('[ACCOUNT]');
    $omnichannelSettingRegionCode = '[REGION_CODE]';
    $omnichannelSettingLsfType = LsfType::LSF_TYPE_UNSPECIFIED;

    create_omnichannel_setting_sample(
        $formattedParent,
        $omnichannelSettingRegionCode,
        $omnichannelSettingLsfType
    );
}
// [END merchantapi_v1_generated_OmnichannelSettingsService_CreateOmnichannelSetting_sync]
