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

// [START admanager_v1_generated_NativeStyleService_BatchUpdateNativeStyles_sync]
use Google\Ads\AdManager\V1\BatchUpdateNativeStylesRequest;
use Google\Ads\AdManager\V1\BatchUpdateNativeStylesResponse;
use Google\Ads\AdManager\V1\Client\NativeStyleServiceClient;
use Google\Ads\AdManager\V1\NativeStyle;
use Google\Ads\AdManager\V1\Size;
use Google\Ads\AdManager\V1\SizeTypeEnum\SizeType;
use Google\Ads\AdManager\V1\UpdateNativeStyleRequest;
use Google\ApiCore\ApiException;

/**
 * Batch updates `NativeStyle` objects.
 *
 * @param string $formattedParent                              The parent resource where `NativeStyles` will be updated.
 *                                                             Format: `networks/{network_code}`
 *                                                             The parent field in the UpdateNativeStyleRequest must match this
 *                                                             field. Please see
 *                                                             {@see NativeStyleServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsNativeStyleCreativeTemplate Immutable. The creative template this native style is associated
 *                                                             with. Format:
 *                                                             "networks/{network_code}/creativeTemplates/{creative_template}"
 *                                                             Please see {@see NativeStyleServiceClient::creativeTemplateName()} for help formatting this field.
 * @param string $requestsNativeStyleDisplayName               The display name of the native style. This attribute has a
 *                                                             maximum length of 255 characters.
 * @param int    $requestsNativeStyleSizeWidth                 The width of the Creative,
 *                                                             [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 * @param int    $requestsNativeStyleSizeHeight                The height of the Creative,
 *                                                             [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 * @param int    $requestsNativeStyleSizeSizeType              The SizeType of the Creative,
 *                                                             [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 */
function batch_update_native_styles_sample(
    string $formattedParent,
    string $formattedRequestsNativeStyleCreativeTemplate,
    string $requestsNativeStyleDisplayName,
    int $requestsNativeStyleSizeWidth,
    int $requestsNativeStyleSizeHeight,
    int $requestsNativeStyleSizeSizeType
): void {
    // Create a client.
    $nativeStyleServiceClient = new NativeStyleServiceClient();

    // Prepare the request message.
    $requestsNativeStyleSize = (new Size())
        ->setWidth($requestsNativeStyleSizeWidth)
        ->setHeight($requestsNativeStyleSizeHeight)
        ->setSizeType($requestsNativeStyleSizeSizeType);
    $requestsNativeStyle = (new NativeStyle())
        ->setCreativeTemplate($formattedRequestsNativeStyleCreativeTemplate)
        ->setDisplayName($requestsNativeStyleDisplayName)
        ->setSize($requestsNativeStyleSize);
    $updateNativeStyleRequest = (new UpdateNativeStyleRequest())
        ->setNativeStyle($requestsNativeStyle);
    $requests = [$updateNativeStyleRequest,];
    $request = (new BatchUpdateNativeStylesRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateNativeStylesResponse $response */
        $response = $nativeStyleServiceClient->batchUpdateNativeStyles($request);
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
    $formattedParent = NativeStyleServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsNativeStyleCreativeTemplate = NativeStyleServiceClient::creativeTemplateName(
        '[NETWORK_CODE]',
        '[CREATIVE_TEMPLATE]'
    );
    $requestsNativeStyleDisplayName = '[DISPLAY_NAME]';
    $requestsNativeStyleSizeWidth = 0;
    $requestsNativeStyleSizeHeight = 0;
    $requestsNativeStyleSizeSizeType = SizeType::SIZE_TYPE_UNSPECIFIED;

    batch_update_native_styles_sample(
        $formattedParent,
        $formattedRequestsNativeStyleCreativeTemplate,
        $requestsNativeStyleDisplayName,
        $requestsNativeStyleSizeWidth,
        $requestsNativeStyleSizeHeight,
        $requestsNativeStyleSizeSizeType
    );
}
// [END admanager_v1_generated_NativeStyleService_BatchUpdateNativeStyles_sync]
