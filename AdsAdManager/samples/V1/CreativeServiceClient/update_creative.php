<?php
/*
 * Copyright 2026 Google LLC
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

// [START admanager_v1_generated_CreativeService_UpdateCreative_sync]
use Google\Ads\AdManager\V1\Client\CreativeServiceClient;
use Google\Ads\AdManager\V1\Creative;
use Google\Ads\AdManager\V1\Size;
use Google\Ads\AdManager\V1\SizeTypeEnum\SizeType;
use Google\Ads\AdManager\V1\UpdateCreativeRequest;
use Google\ApiCore\ApiException;

/**
 * Updates a `Creative` object.
 *
 * @param string $creativeDisplayName         Display name of the `Creative`. This attribute has a maximum
 *                                            length of 255 characters.
 * @param string $formattedCreativeAdvertiser The resource name of the Company, which is of type
 *                                            Company.Type.ADVERTISER, to which this Creative belongs. Format:
 *                                            "networks/{network_code}/companies/{company_id}"
 *                                            Please see {@see CreativeServiceClient::companyName()} for help formatting this field.
 * @param int    $creativeSizeWidth           The width of the Creative,
 *                                            [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 * @param int    $creativeSizeHeight          The height of the Creative,
 *                                            [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 * @param int    $creativeSizeSizeType        The SizeType of the Creative,
 *                                            [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 */
function update_creative_sample(
    string $creativeDisplayName,
    string $formattedCreativeAdvertiser,
    int $creativeSizeWidth,
    int $creativeSizeHeight,
    int $creativeSizeSizeType
): void {
    // Create a client.
    $creativeServiceClient = new CreativeServiceClient();

    // Prepare the request message.
    $creativeSize = (new Size())
        ->setWidth($creativeSizeWidth)
        ->setHeight($creativeSizeHeight)
        ->setSizeType($creativeSizeSizeType);
    $creative = (new Creative())
        ->setDisplayName($creativeDisplayName)
        ->setAdvertiser($formattedCreativeAdvertiser)
        ->setSize($creativeSize);
    $request = (new UpdateCreativeRequest())
        ->setCreative($creative);

    // Call the API and handle any network failures.
    try {
        /** @var Creative $response */
        $response = $creativeServiceClient->updateCreative($request);
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
    $creativeDisplayName = '[DISPLAY_NAME]';
    $formattedCreativeAdvertiser = CreativeServiceClient::companyName('[NETWORK_CODE]', '[COMPANY]');
    $creativeSizeWidth = 0;
    $creativeSizeHeight = 0;
    $creativeSizeSizeType = SizeType::SIZE_TYPE_UNSPECIFIED;

    update_creative_sample(
        $creativeDisplayName,
        $formattedCreativeAdvertiser,
        $creativeSizeWidth,
        $creativeSizeHeight,
        $creativeSizeSizeType
    );
}
// [END admanager_v1_generated_CreativeService_UpdateCreative_sync]
