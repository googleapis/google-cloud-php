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

// [START admanager_v1_generated_AudienceSegmentService_CreateAudienceSegment_sync]
use Google\Ads\AdManager\V1\AudienceSegment;
use Google\Ads\AdManager\V1\Client\AudienceSegmentServiceClient;
use Google\Ads\AdManager\V1\CreateAudienceSegmentRequest;
use Google\ApiCore\ApiException;

/**
 * Creates an `AudienceSegment` object.
 *
 * @param string $formattedParent            The parent resource where this `AudienceSegment` will be created.
 *                                           Format: `networks/{network_code}`
 *                                           Please see {@see AudienceSegmentServiceClient::networkName()} for help formatting this field.
 * @param string $audienceSegmentDisplayName Display name of the `AudienceSegment`. The attribute has a
 *                                           maximum length of 255 characters.
 */
function create_audience_segment_sample(
    string $formattedParent,
    string $audienceSegmentDisplayName
): void {
    // Create a client.
    $audienceSegmentServiceClient = new AudienceSegmentServiceClient();

    // Prepare the request message.
    $audienceSegment = (new AudienceSegment())
        ->setDisplayName($audienceSegmentDisplayName);
    $request = (new CreateAudienceSegmentRequest())
        ->setParent($formattedParent)
        ->setAudienceSegment($audienceSegment);

    // Call the API and handle any network failures.
    try {
        /** @var AudienceSegment $response */
        $response = $audienceSegmentServiceClient->createAudienceSegment($request);
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
    $formattedParent = AudienceSegmentServiceClient::networkName('[NETWORK_CODE]');
    $audienceSegmentDisplayName = '[DISPLAY_NAME]';

    create_audience_segment_sample($formattedParent, $audienceSegmentDisplayName);
}
// [END admanager_v1_generated_AudienceSegmentService_CreateAudienceSegment_sync]
