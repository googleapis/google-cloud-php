<?php
/*
 * Copyright 2024 Google LLC
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

// [START gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_CreateSite_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GdcHardwareManagement\V1alpha\Client\GDCHardwareManagementClient;
use Google\Cloud\GdcHardwareManagement\V1alpha\Contact;
use Google\Cloud\GdcHardwareManagement\V1alpha\CreateSiteRequest;
use Google\Cloud\GdcHardwareManagement\V1alpha\OrganizationContact;
use Google\Cloud\GdcHardwareManagement\V1alpha\Site;
use Google\Rpc\Status;
use Google\Type\PostalAddress;

/**
 * Creates a new site in a given project and location.
 *
 * @param string $formattedParent                          The project and location to create the site in.
 *                                                         Format: `projects/{project}/locations/{location}`
 *                                                         Please see {@see GDCHardwareManagementClient::locationName()} for help formatting this field.
 * @param string $siteOrganizationContactContactsGivenName Given name of the contact.
 * @param string $siteOrganizationContactContactsEmail     Email of the contact.
 * @param string $siteOrganizationContactContactsPhone     Phone number of the contact.
 * @param string $siteGoogleMapsPinUri                     A URL to the Google Maps address location of the site.
 *                                                         An example value is `https://goo.gl/maps/xxxxxxxxx`.
 */
function create_site_sample(
    string $formattedParent,
    string $siteOrganizationContactContactsGivenName,
    string $siteOrganizationContactContactsEmail,
    string $siteOrganizationContactContactsPhone,
    string $siteGoogleMapsPinUri
): void {
    // Create a client.
    $gDCHardwareManagementClient = new GDCHardwareManagementClient();

    // Prepare the request message.
    $siteOrganizationContactAddress = new PostalAddress();
    $contact = (new Contact())
        ->setGivenName($siteOrganizationContactContactsGivenName)
        ->setEmail($siteOrganizationContactContactsEmail)
        ->setPhone($siteOrganizationContactContactsPhone);
    $siteOrganizationContactContacts = [$contact,];
    $siteOrganizationContact = (new OrganizationContact())
        ->setAddress($siteOrganizationContactAddress)
        ->setContacts($siteOrganizationContactContacts);
    $site = (new Site())
        ->setOrganizationContact($siteOrganizationContact)
        ->setGoogleMapsPinUri($siteGoogleMapsPinUri);
    $request = (new CreateSiteRequest())
        ->setParent($formattedParent)
        ->setSite($site);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gDCHardwareManagementClient->createSite($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Site $result */
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
    $formattedParent = GDCHardwareManagementClient::locationName('[PROJECT]', '[LOCATION]');
    $siteOrganizationContactContactsGivenName = '[GIVEN_NAME]';
    $siteOrganizationContactContactsEmail = '[EMAIL]';
    $siteOrganizationContactContactsPhone = '[PHONE]';
    $siteGoogleMapsPinUri = '[GOOGLE_MAPS_PIN_URI]';

    create_site_sample(
        $formattedParent,
        $siteOrganizationContactContactsGivenName,
        $siteOrganizationContactContactsEmail,
        $siteOrganizationContactContactsPhone,
        $siteGoogleMapsPinUri
    );
}
// [END gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_CreateSite_sync]
