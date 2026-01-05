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

// [START admanager_v1_generated_AdReviewCenterAdService_BatchBlockAdReviewCenterAds_sync]
use Google\Ads\AdManager\V1\BatchBlockAdReviewCenterAdsRequest;
use Google\Ads\AdManager\V1\BatchBlockAdReviewCenterAdsResponse;
use Google\Ads\AdManager\V1\Client\AdReviewCenterAdServiceClient;
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Rpc\Status;

/**
 * API to batch block AdReviewCenterAds.
 * This method supports partial success. Some operations may succeed while
 * others fail. Callers should check the failedRequests field in the response
 * to determine which operations failed.
 *
 * @param string $formattedParent       The parent, which owns this collection of AdReviewCenterAds.
 *                                      Format: networks/{network_code}/webProperties/{web_property_code}
 *
 *                                      Since a network can only have a single web property of each
 *                                      `ExchangeSyndicationProduct`, you can use the
 *                                      `ExchangeSyndicationProduct` as an alias for the web property code:
 *
 *                                      `networks/{network_code}/webProperties/display`
 *
 *                                      `networks/{network_code}/webProperties/videoAndAudio`
 *
 *                                      `networks/{network_code}/webProperties/mobileApp`
 *
 *                                      `networks/{network_code}/webProperties/games`
 *                                      Please see {@see AdReviewCenterAdServiceClient::webPropertyName()} for help formatting this field.
 * @param string $formattedNamesElement The resource names of the `AdReviewCenterAd`s to block.
 *                                      Format:
 *                                      `networks/{network_code}/webProperties/{web_property_code}/adReviewCenterAds/{ad_review_center_ad_id}`
 *                                      Please see {@see AdReviewCenterAdServiceClient::adReviewCenterAdName()} for help formatting this field.
 */
function batch_block_ad_review_center_ads_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $adReviewCenterAdServiceClient = new AdReviewCenterAdServiceClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new BatchBlockAdReviewCenterAdsRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $adReviewCenterAdServiceClient->batchBlockAdReviewCenterAds($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BatchBlockAdReviewCenterAdsResponse $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedParent = AdReviewCenterAdServiceClient::webPropertyName(
        '[NETWORK_CODE]',
        '[WEB_PROPERTY]'
    );
    $formattedNamesElement = AdReviewCenterAdServiceClient::adReviewCenterAdName(
        '[NETWORK_CODE]',
        '[WEB_PROPERTY_CODE]',
        '[AD_REVIEW_CENTER_AD]'
    );

    batch_block_ad_review_center_ads_sample($formattedParent, $formattedNamesElement);
}
// [END admanager_v1_generated_AdReviewCenterAdService_BatchBlockAdReviewCenterAds_sync]
