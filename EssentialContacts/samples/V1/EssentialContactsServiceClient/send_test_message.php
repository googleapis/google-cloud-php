<?php
/*
 * Copyright 2022 Google LLC
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

// [START essentialcontacts_v1_generated_EssentialContactsService_SendTestMessage_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\EssentialContacts\V1\Client\EssentialContactsServiceClient;
use Google\Cloud\EssentialContacts\V1\NotificationCategory;
use Google\Cloud\EssentialContacts\V1\SendTestMessageRequest;

/**
 * Allows a contact admin to send a test message to contact to verify that it
 * has been configured correctly.
 *
 * @param string $formattedContactsElement The list of names of the contacts to send a test message to.
 *                                         Format: organizations/{organization_id}/contacts/{contact_id},
 *                                         folders/{folder_id}/contacts/{contact_id} or
 *                                         projects/{project_id}/contacts/{contact_id}
 *                                         Please see {@see EssentialContactsServiceClient::contactName()} for help formatting this field.
 * @param string $formattedResource        The name of the resource to send the test message for. All
 *                                         contacts must either be set directly on this resource or inherited from
 *                                         another resource that is an ancestor of this one. Format:
 *                                         organizations/{organization_id}, folders/{folder_id} or
 *                                         projects/{project_id}
 *                                         Please see {@see EssentialContactsServiceClient::projectName()} for help formatting this field.
 * @param int    $notificationCategory     The notification category to send the test message for. All
 *                                         contacts must be subscribed to this category.
 */
function send_test_message_sample(
    string $formattedContactsElement,
    string $formattedResource,
    int $notificationCategory
): void {
    // Create a client.
    $essentialContactsServiceClient = new EssentialContactsServiceClient();

    // Prepare the request message.
    $formattedContacts = [$formattedContactsElement,];
    $request = (new SendTestMessageRequest())
        ->setContacts($formattedContacts)
        ->setResource($formattedResource)
        ->setNotificationCategory($notificationCategory);

    // Call the API and handle any network failures.
    try {
        $essentialContactsServiceClient->sendTestMessage($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedContactsElement = EssentialContactsServiceClient::contactName('[PROJECT]', '[CONTACT]');
    $formattedResource = EssentialContactsServiceClient::projectName('[PROJECT]');
    $notificationCategory = NotificationCategory::NOTIFICATION_CATEGORY_UNSPECIFIED;

    send_test_message_sample($formattedContactsElement, $formattedResource, $notificationCategory);
}
// [END essentialcontacts_v1_generated_EssentialContactsService_SendTestMessage_sync]
