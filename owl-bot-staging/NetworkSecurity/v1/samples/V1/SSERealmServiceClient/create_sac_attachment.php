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

// [START networksecurity_v1_generated_SSERealmService_CreateSACAttachment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\SSERealmServiceClient;
use Google\Cloud\NetworkSecurity\V1\CreateSACAttachmentRequest;
use Google\Cloud\NetworkSecurity\V1\SACAttachment;
use Google\Rpc\Status;

/**
 * Creates a new SACAttachment in a given project and location.
 *
 * @param string $formattedParent         The parent, in the form
 *                                        `projects/{project}/locations/{location}`. Please see
 *                                        {@see SSERealmServiceClient::locationName()} for help formatting this field.
 * @param string $sacAttachmentId         ID of the created attachment.
 *                                        The ID must be 1-63 characters long, and comply with
 *                                        <a href="https://www.ietf.org/rfc/rfc1035.txt" target="_blank">RFC1035</a>.
 *                                        Specifically, it must be 1-63 characters long and match the regular
 *                                        expression `[a-z]([-a-z0-9]*[a-z0-9])?`
 *                                        which means the first character must be a lowercase letter, and all
 *                                        following characters must be a dash, lowercase letter, or digit, except
 *                                        the last character, which cannot be a dash.
 * @param string $sacAttachmentSacRealm   SAC Realm which owns the attachment. This can be input as an ID
 *                                        or a full resource name. The output always has the form
 *                                        `projects/{project_number}/locations/{location}/sacRealms/{sac_realm}`.
 * @param string $sacAttachmentNccGateway NCC Gateway associated with the attachment. This can be input as
 *                                        an ID or a full resource name. The output always has the form
 *                                        `projects/{project_number}/locations/{location}/spokes/{ncc_gateway}`.
 */
function create_sac_attachment_sample(
    string $formattedParent,
    string $sacAttachmentId,
    string $sacAttachmentSacRealm,
    string $sacAttachmentNccGateway
): void {
    // Create a client.
    $sSERealmServiceClient = new SSERealmServiceClient();

    // Prepare the request message.
    $sacAttachment = (new SACAttachment())
        ->setSacRealm($sacAttachmentSacRealm)
        ->setNccGateway($sacAttachmentNccGateway);
    $request = (new CreateSACAttachmentRequest())
        ->setParent($formattedParent)
        ->setSacAttachmentId($sacAttachmentId)
        ->setSacAttachment($sacAttachment);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $sSERealmServiceClient->createSACAttachment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var SACAttachment $result */
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
    $formattedParent = SSERealmServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $sacAttachmentId = '[SAC_ATTACHMENT_ID]';
    $sacAttachmentSacRealm = '[SAC_REALM]';
    $sacAttachmentNccGateway = '[NCC_GATEWAY]';

    create_sac_attachment_sample(
        $formattedParent,
        $sacAttachmentId,
        $sacAttachmentSacRealm,
        $sacAttachmentNccGateway
    );
}
// [END networksecurity_v1_generated_SSERealmService_CreateSACAttachment_sync]
