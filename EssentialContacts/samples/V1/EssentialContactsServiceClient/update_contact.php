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

// [START essentialcontacts_v1_generated_EssentialContactsService_UpdateContact_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\EssentialContacts\V1\Client\EssentialContactsServiceClient;
use Google\Cloud\EssentialContacts\V1\Contact;
use Google\Cloud\EssentialContacts\V1\NotificationCategory;
use Google\Cloud\EssentialContacts\V1\UpdateContactRequest;

/**
 * Updates a contact.
 * Note: A contact's email address cannot be changed.
 *
 * @param string $contactEmail                                    The email address to send notifications to. The email address
 *                                                                does not need to be a Google Account.
 * @param int    $contactNotificationCategorySubscriptionsElement The categories of notifications that the contact will receive
 *                                                                communications for.
 * @param string $contactLanguageTag                              The preferred language for notifications, as a ISO 639-1 language
 *                                                                code. See [Supported
 *                                                                languages](https://cloud.google.com/resource-manager/docs/managing-notification-contacts#supported-languages)
 *                                                                for a list of supported languages.
 */
function update_contact_sample(
    string $contactEmail,
    int $contactNotificationCategorySubscriptionsElement,
    string $contactLanguageTag
): void {
    // Create a client.
    $essentialContactsServiceClient = new EssentialContactsServiceClient();

    // Prepare the request message.
    $contactNotificationCategorySubscriptions = [$contactNotificationCategorySubscriptionsElement,];
    $contact = (new Contact())
        ->setEmail($contactEmail)
        ->setNotificationCategorySubscriptions($contactNotificationCategorySubscriptions)
        ->setLanguageTag($contactLanguageTag);
    $request = (new UpdateContactRequest())
        ->setContact($contact);

    // Call the API and handle any network failures.
    try {
        /** @var Contact $response */
        $response = $essentialContactsServiceClient->updateContact($request);
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
    $contactEmail = '[EMAIL]';
    $contactNotificationCategorySubscriptionsElement = NotificationCategory::NOTIFICATION_CATEGORY_UNSPECIFIED;
    $contactLanguageTag = '[LANGUAGE_TAG]';

    update_contact_sample(
        $contactEmail,
        $contactNotificationCategorySubscriptionsElement,
        $contactLanguageTag
    );
}
// [END essentialcontacts_v1_generated_EssentialContactsService_UpdateContact_sync]
