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

// [START admanager_v1_generated_CreativeService_BatchUpdateCreatives_sync]
use Google\Ads\AdManager\V1\BatchUpdateCreativesRequest;
use Google\Ads\AdManager\V1\BatchUpdateCreativesResponse;
use Google\Ads\AdManager\V1\Client\CreativeServiceClient;
use Google\Ads\AdManager\V1\Creative;
use Google\Ads\AdManager\V1\Size;
use Google\Ads\AdManager\V1\SizeTypeEnum\SizeType;
use Google\Ads\AdManager\V1\UpdateCreativeRequest;
use Google\ApiCore\ApiException;

/**
 * Batch updates `Creative` objects.
 *
 * @param string $formattedParent                     The parent resource where `Creatives` will be updated.
 *                                                    Format: `networks/{network_code}`
 *                                                    The parent field in the UpdateCreativeRequest must match this
 *                                                    field. Please see
 *                                                    {@see CreativeServiceClient::networkName()} for help formatting this field.
 * @param string $requestsCreativeDisplayName         Display name of the `Creative`. This attribute has a maximum
 *                                                    length of 255 characters.
 * @param string $formattedRequestsCreativeAdvertiser The resource name of the Company, which is of type
 *                                                    Company.Type.ADVERTISER, to which this Creative belongs. Format:
 *                                                    "networks/{network_code}/companies/{company_id}"
 *                                                    Please see {@see CreativeServiceClient::companyName()} for help formatting this field.
 * @param int    $requestsCreativeSizeWidth           The width of the Creative,
 *                                                    [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 * @param int    $requestsCreativeSizeHeight          The height of the Creative,
 *                                                    [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 * @param int    $requestsCreativeSizeSizeType        The SizeType of the Creative,
 *                                                    [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 */
function batch_update_creatives_sample(
    string $formattedParent,
    string $requestsCreativeDisplayName,
    string $formattedRequestsCreativeAdvertiser,
    int $requestsCreativeSizeWidth,
    int $requestsCreativeSizeHeight,
    int $requestsCreativeSizeSizeType
): void {
    // Create a client.
    $creativeServiceClient = new CreativeServiceClient();

    // Prepare the request message.
    $requestsCreativeSize = (new Size())
        ->setWidth($requestsCreativeSizeWidth)
        ->setHeight($requestsCreativeSizeHeight)
        ->setSizeType($requestsCreativeSizeSizeType);
    $requestsCreative = (new Creative())
        ->setDisplayName($requestsCreativeDisplayName)
        ->setAdvertiser($formattedRequestsCreativeAdvertiser)
        ->setSize($requestsCreativeSize);
    $updateCreativeRequest = (new UpdateCreativeRequest())
        ->setCreative($requestsCreative);
    $requests = [$updateCreativeRequest];
    $request = (new BatchUpdateCreativesRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateCreativesResponse $response */
        $response = $creativeServiceClient->batchUpdateCreatives($request);
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
    $formattedParent = CreativeServiceClient::networkName('[NETWORK_CODE]');
    $requestsCreativeDisplayName = '[DISPLAY_NAME]';
    $formattedRequestsCreativeAdvertiser = CreativeServiceClient::companyName(
        '[NETWORK_CODE]',
        '[COMPANY]'
    );
    $requestsCreativeSizeWidth = 0;
    $requestsCreativeSizeHeight = 0;
    $requestsCreativeSizeSizeType = SizeType::SIZE_TYPE_UNSPECIFIED;

    batch_update_creatives_sample(
        $formattedParent,
        $requestsCreativeDisplayName,
        $formattedRequestsCreativeAdvertiser,
        $requestsCreativeSizeWidth,
        $requestsCreativeSizeHeight,
        $requestsCreativeSizeSizeType
    );
}
// [END admanager_v1_generated_CreativeService_BatchUpdateCreatives_sync]
