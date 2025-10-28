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

// [START admanager_v1_generated_ContactService_CreateContact_sync]
use Google\Ads\AdManager\V1\Client\ContactServiceClient;
use Google\Ads\AdManager\V1\Contact;
use Google\Ads\AdManager\V1\CreateContactRequest;
use Google\ApiCore\ApiException;

/**
 * API to create a `Contact` object.
 *
 * @param string $formattedParent         The parent resource where this `Contact` will be created.
 *                                        Format: `networks/{network_code}`
 *                                        Please see {@see ContactServiceClient::networkName()} for help formatting this field.
 * @param string $contactDisplayName      The name of the contact. This attribute has a maximum length of
 *                                        127 characters.
 * @param string $formattedContactCompany Immutable. The resource name of the Company.
 *                                        Format: "networks/{network_code}/companies/{company_id}"
 *                                        Please see {@see ContactServiceClient::companyName()} for help formatting this field.
 */
function create_contact_sample(
    string $formattedParent,
    string $contactDisplayName,
    string $formattedContactCompany
): void {
    // Create a client.
    $contactServiceClient = new ContactServiceClient();

    // Prepare the request message.
    $contact = (new Contact())
        ->setDisplayName($contactDisplayName)
        ->setCompany($formattedContactCompany);
    $request = (new CreateContactRequest())
        ->setParent($formattedParent)
        ->setContact($contact);

    // Call the API and handle any network failures.
    try {
        /** @var Contact $response */
        $response = $contactServiceClient->createContact($request);
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
    $formattedParent = ContactServiceClient::networkName('[NETWORK_CODE]');
    $contactDisplayName = '[DISPLAY_NAME]';
    $formattedContactCompany = ContactServiceClient::companyName('[NETWORK_CODE]', '[COMPANY]');

    create_contact_sample($formattedParent, $contactDisplayName, $formattedContactCompany);
}
// [END admanager_v1_generated_ContactService_CreateContact_sync]
