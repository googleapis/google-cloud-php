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

// [START admanager_v1_generated_ChildPublisherService_BatchResendChildPublisherInvitationEmails_sync]
use Google\Ads\AdManager\V1\BatchResendChildPublisherInvitationEmailsRequest;
use Google\Ads\AdManager\V1\BatchResendChildPublisherInvitationEmailsResponse;
use Google\Ads\AdManager\V1\Client\ChildPublisherServiceClient;
use Google\ApiCore\ApiException;

/**
 * Batch resends invitation emails to
 * [ChildPublisher][google.ads.admanager.v1.ChildPublisher]s.
 *
 * Only expired and pending
 * [ChildPublisher][google.ads.admanager.v1.ChildPublisher]s can be sent
 * invitation emails. Rejected, withdrawn, and accepted
 * [ChildPublisher][google.ads.admanager.v1.ChildPublisher]s will be ignored.
 *
 * @param string $formattedParent       Format: `networks/{network_code}`
 *                                      Please see {@see ChildPublisherServiceClient::networkName()} for help formatting this field.
 * @param string $formattedNamesElement Resource names of the
 *                                      [ChildPublisher][google.ads.admanager.v1.ChildPublisher]s that should be
 *                                      resent invitation emails. Format:
 *                                      `networks/{network_code}/childPublisher/{child_publisher_id}`
 *                                      Please see {@see ChildPublisherServiceClient::childPublisherName()} for help formatting this field.
 */
function batch_resend_child_publisher_invitation_emails_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $childPublisherServiceClient = new ChildPublisherServiceClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new BatchResendChildPublisherInvitationEmailsRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var BatchResendChildPublisherInvitationEmailsResponse $response */
        $response = $childPublisherServiceClient->batchResendChildPublisherInvitationEmails($request);
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
    $formattedNamesElement = ChildPublisherServiceClient::childPublisherName(
        '[NETWORK_CODE]',
        '[CHILD_PUBLISHER]'
    );

    batch_resend_child_publisher_invitation_emails_sample($formattedParent, $formattedNamesElement);
}
// [END admanager_v1_generated_ChildPublisherService_BatchResendChildPublisherInvitationEmails_sync]
