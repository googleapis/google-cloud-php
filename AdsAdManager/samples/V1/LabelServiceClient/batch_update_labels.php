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

// [START admanager_v1_generated_LabelService_BatchUpdateLabels_sync]
use Google\Ads\AdManager\V1\BatchUpdateLabelsRequest;
use Google\Ads\AdManager\V1\BatchUpdateLabelsResponse;
use Google\Ads\AdManager\V1\Client\LabelServiceClient;
use Google\Ads\AdManager\V1\Label;
use Google\Ads\AdManager\V1\LabelTypeEnum\LabelType;
use Google\Ads\AdManager\V1\UpdateLabelRequest;
use Google\ApiCore\ApiException;

/**
 * API to batch update `Label` objects.
 *
 * @param string $formattedParent           The parent resource where `Labels` will be updated.
 *                                          Format: `networks/{network_code}`
 *                                          The parent field in the UpdateLabelRequest must match this
 *                                          field. Please see
 *                                          {@see LabelServiceClient::networkName()} for help formatting this field.
 * @param string $requestsLabelDisplayName  Display name of the Label. This attribute has a maximum length of
 *                                          127 characters.
 * @param int    $requestsLabelTypesElement Unordered list. The types of the Label.
 */
function batch_update_labels_sample(
    string $formattedParent,
    string $requestsLabelDisplayName,
    int $requestsLabelTypesElement
): void {
    // Create a client.
    $labelServiceClient = new LabelServiceClient();

    // Prepare the request message.
    $requestsLabelTypes = [$requestsLabelTypesElement,];
    $requestsLabel = (new Label())
        ->setDisplayName($requestsLabelDisplayName)
        ->setTypes($requestsLabelTypes);
    $updateLabelRequest = (new UpdateLabelRequest())
        ->setLabel($requestsLabel);
    $requests = [$updateLabelRequest,];
    $request = (new BatchUpdateLabelsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateLabelsResponse $response */
        $response = $labelServiceClient->batchUpdateLabels($request);
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
    $formattedParent = LabelServiceClient::networkName('[NETWORK_CODE]');
    $requestsLabelDisplayName = '[DISPLAY_NAME]';
    $requestsLabelTypesElement = LabelType::LABEL_TYPE_UNSPECIFIED;

    batch_update_labels_sample($formattedParent, $requestsLabelDisplayName, $requestsLabelTypesElement);
}
// [END admanager_v1_generated_LabelService_BatchUpdateLabels_sync]
