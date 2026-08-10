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

// [START admanager_v1_generated_CreativeWrapperService_BatchUpdateCreativeWrappers_sync]
use Google\Ads\AdManager\V1\BatchUpdateCreativeWrappersRequest;
use Google\Ads\AdManager\V1\BatchUpdateCreativeWrappersResponse;
use Google\Ads\AdManager\V1\Client\CreativeWrapperServiceClient;
use Google\Ads\AdManager\V1\CreativeWrapper;
use Google\Ads\AdManager\V1\CreativeWrapperTypeEnum\CreativeWrapperType;
use Google\Ads\AdManager\V1\UpdateCreativeWrapperRequest;
use Google\ApiCore\ApiException;

/**
 * Batch updates `CreativeWrapper` objects.
 *
 * @param string $formattedParent                            The parent resource where `CreativeWrappers` will be updated.
 *                                                           Format: `networks/{network_code}`
 *                                                           The parent field in the UpdateCreativeWrapperRequest must match this
 *                                                           field. Please see
 *                                                           {@see CreativeWrapperServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsCreativeWrapperLabel      Immutable. The resource name of the
 *                                                           [Label][google.ads.admanager.v1.Label].
 *                                                           Format:`networks/{network_code}/label/{label_id}`
 *                                                           Please see {@see CreativeWrapperServiceClient::labelName()} for help formatting this field.
 * @param int    $requestsCreativeWrapperCreativeWrapperType The `creative_wrapper_type`. If the `creative_wrapper_type` is
 *                                                           [CreativeWrapperType.VIDEO_TRACKING_URL][google.ads.admanager.v1.CreativeWrapperTypeEnum.CreativeWrapperType.VIDEO_TRACKING_URL],
 *                                                           the `video_tracking_urls` field must be set. If the `creative_wrapper_type`
 *                                                           is
 *                                                           [CreativeWrapperType.HTML][google.ads.admanager.v1.CreativeWrapperTypeEnum.CreativeWrapperType.HTML],
 *                                                           either the header or footer field must be set.
 */
function batch_update_creative_wrappers_sample(
    string $formattedParent,
    string $formattedRequestsCreativeWrapperLabel,
    int $requestsCreativeWrapperCreativeWrapperType
): void {
    // Create a client.
    $creativeWrapperServiceClient = new CreativeWrapperServiceClient();

    // Prepare the request message.
    $requestsCreativeWrapper = (new CreativeWrapper())
        ->setLabel($formattedRequestsCreativeWrapperLabel)
        ->setCreativeWrapperType($requestsCreativeWrapperCreativeWrapperType);
    $updateCreativeWrapperRequest = (new UpdateCreativeWrapperRequest())
        ->setCreativeWrapper($requestsCreativeWrapper);
    $requests = [$updateCreativeWrapperRequest,];
    $request = (new BatchUpdateCreativeWrappersRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateCreativeWrappersResponse $response */
        $response = $creativeWrapperServiceClient->batchUpdateCreativeWrappers($request);
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
    $formattedParent = CreativeWrapperServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsCreativeWrapperLabel = CreativeWrapperServiceClient::labelName(
        '[NETWORK_CODE]',
        '[LABEL]'
    );
    $requestsCreativeWrapperCreativeWrapperType = CreativeWrapperType::CREATIVE_WRAPPER_TYPE_UNSPECIFIED;

    batch_update_creative_wrappers_sample(
        $formattedParent,
        $formattedRequestsCreativeWrapperLabel,
        $requestsCreativeWrapperCreativeWrapperType
    );
}
// [END admanager_v1_generated_CreativeWrapperService_BatchUpdateCreativeWrappers_sync]
