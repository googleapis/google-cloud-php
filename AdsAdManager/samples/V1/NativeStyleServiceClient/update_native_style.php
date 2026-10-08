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

// [START admanager_v1_generated_NativeStyleService_UpdateNativeStyle_sync]
use Google\Ads\AdManager\V1\Client\NativeStyleServiceClient;
use Google\Ads\AdManager\V1\NativeStyle;
use Google\Ads\AdManager\V1\Size;
use Google\Ads\AdManager\V1\SizeTypeEnum\SizeType;
use Google\Ads\AdManager\V1\UpdateNativeStyleRequest;
use Google\ApiCore\ApiException;

/**
 * Updates a `NativeStyle` object.
 *
 * @param string $formattedNativeStyleCreativeTemplate Immutable. The creative template this native style is associated
 *                                                     with. Format:
 *                                                     "networks/{network_code}/creativeTemplates/{creative_template}"
 *                                                     Please see {@see NativeStyleServiceClient::creativeTemplateName()} for help formatting this field.
 * @param string $nativeStyleDisplayName               The display name of the native style. This attribute has a
 *                                                     maximum length of 255 characters.
 * @param int    $nativeStyleSizeWidth                 The width of the Creative,
 *                                                     [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 * @param int    $nativeStyleSizeHeight                The height of the Creative,
 *                                                     [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 * @param int    $nativeStyleSizeSizeType              The SizeType of the Creative,
 *                                                     [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 */
function update_native_style_sample(
    string $formattedNativeStyleCreativeTemplate,
    string $nativeStyleDisplayName,
    int $nativeStyleSizeWidth,
    int $nativeStyleSizeHeight,
    int $nativeStyleSizeSizeType
): void {
    // Create a client.
    $nativeStyleServiceClient = new NativeStyleServiceClient();

    // Prepare the request message.
    $nativeStyleSize = (new Size())
        ->setWidth($nativeStyleSizeWidth)
        ->setHeight($nativeStyleSizeHeight)
        ->setSizeType($nativeStyleSizeSizeType);
    $nativeStyle = (new NativeStyle())
        ->setCreativeTemplate($formattedNativeStyleCreativeTemplate)
        ->setDisplayName($nativeStyleDisplayName)
        ->setSize($nativeStyleSize);
    $request = (new UpdateNativeStyleRequest())
        ->setNativeStyle($nativeStyle);

    // Call the API and handle any network failures.
    try {
        /** @var NativeStyle $response */
        $response = $nativeStyleServiceClient->updateNativeStyle($request);
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
    $formattedNativeStyleCreativeTemplate = NativeStyleServiceClient::creativeTemplateName(
        '[NETWORK_CODE]',
        '[CREATIVE_TEMPLATE]'
    );
    $nativeStyleDisplayName = '[DISPLAY_NAME]';
    $nativeStyleSizeWidth = 0;
    $nativeStyleSizeHeight = 0;
    $nativeStyleSizeSizeType = SizeType::SIZE_TYPE_UNSPECIFIED;

    update_native_style_sample(
        $formattedNativeStyleCreativeTemplate,
        $nativeStyleDisplayName,
        $nativeStyleSizeWidth,
        $nativeStyleSizeHeight,
        $nativeStyleSizeSizeType
    );
}
// [END admanager_v1_generated_NativeStyleService_UpdateNativeStyle_sync]
