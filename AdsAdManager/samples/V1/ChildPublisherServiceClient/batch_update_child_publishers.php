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

// [START admanager_v1_generated_ChildPublisherService_BatchUpdateChildPublishers_sync]
use Google\Ads\AdManager\V1\BatchUpdateChildPublishersRequest;
use Google\Ads\AdManager\V1\BatchUpdateChildPublishersResponse;
use Google\Ads\AdManager\V1\ChildPublisher;
use Google\Ads\AdManager\V1\Client\ChildPublisherServiceClient;
use Google\Ads\AdManager\V1\DelegationTypeEnum\DelegationType;
use Google\Ads\AdManager\V1\UpdateChildPublisherRequest;
use Google\ApiCore\ApiException;

/**
 * Batch updates [ChildPublisher][google.ads.admanager.v1.ChildPublisher]
 * objects.
 *
 * @param string $formattedParent                      The parent resource where
 *                                                     [ChildPublisher][google.ads.admanager.v1.ChildPublisher]s will be updated.
 *                                                     Format: `networks/{network_code}`
 *                                                     The parent field in the UpdateChildPublisherRequest must match this
 *                                                     field. Please see
 *                                                     {@see ChildPublisherServiceClient::networkName()} for help formatting this field.
 * @param string $requestsChildPublisherDisplayName    The display name of the
 *                                                     [ChildPublisher][google.ads.admanager.v1.ChildPublisher].
 * @param string $requestsChildPublisherEmail          The email for the
 *                                                     [ChildPublisher][google.ads.admanager.v1.ChildPublisher].
 * @param int    $requestsChildPublisherDelegationType The type of delegation for the
 *                                                     [ChildPublisher][google.ads.admanager.v1.ChildPublisher].
 *
 *                                                     This attribute is immutable while the relationship is active.
 */
function batch_update_child_publishers_sample(
    string $formattedParent,
    string $requestsChildPublisherDisplayName,
    string $requestsChildPublisherEmail,
    int $requestsChildPublisherDelegationType
): void {
    // Create a client.
    $childPublisherServiceClient = new ChildPublisherServiceClient();

    // Prepare the request message.
    $requestsChildPublisher = (new ChildPublisher())
        ->setDisplayName($requestsChildPublisherDisplayName)
        ->setEmail($requestsChildPublisherEmail)
        ->setDelegationType($requestsChildPublisherDelegationType);
    $updateChildPublisherRequest = (new UpdateChildPublisherRequest())
        ->setChildPublisher($requestsChildPublisher);
    $requests = [$updateChildPublisherRequest,];
    $request = (new BatchUpdateChildPublishersRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateChildPublishersResponse $response */
        $response = $childPublisherServiceClient->batchUpdateChildPublishers($request);
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
    $formattedParent = ChildPublisherServiceClient::networkName('[NETWORK_CODE]');
    $requestsChildPublisherDisplayName = '[DISPLAY_NAME]';
    $requestsChildPublisherEmail = '[EMAIL]';
    $requestsChildPublisherDelegationType = DelegationType::DELEGATION_TYPE_UNSPECIFIED;

    batch_update_child_publishers_sample(
        $formattedParent,
        $requestsChildPublisherDisplayName,
        $requestsChildPublisherEmail,
        $requestsChildPublisherDelegationType
    );
}
// [END admanager_v1_generated_ChildPublisherService_BatchUpdateChildPublishers_sync]
