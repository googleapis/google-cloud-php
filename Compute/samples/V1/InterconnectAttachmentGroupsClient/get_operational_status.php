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

// [START compute_v1_generated_InterconnectAttachmentGroups_GetOperationalStatus_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Compute\V1\Client\InterconnectAttachmentGroupsClient;
use Google\Cloud\Compute\V1\GetOperationalStatusInterconnectAttachmentGroupRequest;
use Google\Cloud\Compute\V1\InterconnectAttachmentGroupsGetOperationalStatusResponse;

/**
 * Returns the InterconnectAttachmentStatuses for the specified InterconnectAttachmentGroup resource.
 *
 * @param string $interconnectAttachmentGroup Name of the interconnectAttachmentGroup resource to query.
 * @param string $project                     Project ID for this request.
 */
function get_operational_status_sample(string $interconnectAttachmentGroup, string $project): void
{
    // Create a client.
    $interconnectAttachmentGroupsClient = new InterconnectAttachmentGroupsClient();

    // Prepare the request message.
    $request = (new GetOperationalStatusInterconnectAttachmentGroupRequest())
        ->setInterconnectAttachmentGroup($interconnectAttachmentGroup)
        ->setProject($project);

    // Call the API and handle any network failures.
    try {
        /** @var InterconnectAttachmentGroupsGetOperationalStatusResponse $response */
        $response = $interconnectAttachmentGroupsClient->getOperationalStatus($request);
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
    $interconnectAttachmentGroup = '[INTERCONNECT_ATTACHMENT_GROUP]';
    $project = '[PROJECT]';

    get_operational_status_sample($interconnectAttachmentGroup, $project);
}
// [END compute_v1_generated_InterconnectAttachmentGroups_GetOperationalStatus_sync]
