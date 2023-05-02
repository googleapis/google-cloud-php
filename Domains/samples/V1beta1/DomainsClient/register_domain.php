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

// [START domains_v1beta1_generated_Domains_RegisterDomain_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Domains\V1beta1\ContactPrivacy;
use Google\Cloud\Domains\V1beta1\ContactSettings;
use Google\Cloud\Domains\V1beta1\ContactSettings\Contact;
use Google\Cloud\Domains\V1beta1\DomainsClient;
use Google\Cloud\Domains\V1beta1\Registration;
use Google\Rpc\Status;
use Google\Type\Money;
use Google\Type\PostalAddress;

/**
 * Registers a new domain name and creates a corresponding `Registration`
 * resource.
 *
 * Call `RetrieveRegisterParameters` first to check availability of the domain
 * name and determine parameters like price that are needed to build a call to
 * this method.
 *
 * A successful call creates a `Registration` resource in state
 * `REGISTRATION_PENDING`, which resolves to `ACTIVE` within 1-2
 * minutes, indicating that the domain was successfully registered. If the
 * resource ends up in state `REGISTRATION_FAILED`, it indicates that the
 * domain was not registered successfully, and you can safely delete the
 * resource and retry registration.
 *
 * @param string $formattedParent                                         The parent resource of the `Registration`. Must be in the
 *                                                                        format `projects/&#42;/locations/*`. Please see
 *                                                                        {@see DomainsClient::locationName()} for help formatting this field.
 * @param string $registrationDomainName                                  Immutable. The domain name. Unicode domain names must be expressed in Punycode format.
 * @param int    $registrationContactSettingsPrivacy                      Privacy setting for the contacts associated with the `Registration`.
 * @param string $registrationContactSettingsRegistrantContactEmail       Email address of the contact.
 * @param string $registrationContactSettingsRegistrantContactPhoneNumber Phone number of the contact in international format. For example,
 *                                                                        `"+1-800-555-0123"`.
 * @param string $registrationContactSettingsAdminContactEmail            Email address of the contact.
 * @param string $registrationContactSettingsAdminContactPhoneNumber      Phone number of the contact in international format. For example,
 *                                                                        `"+1-800-555-0123"`.
 * @param string $registrationContactSettingsTechnicalContactEmail        Email address of the contact.
 * @param string $registrationContactSettingsTechnicalContactPhoneNumber  Phone number of the contact in international format. For example,
 *                                                                        `"+1-800-555-0123"`.
 */
function register_domain_sample(
    string $formattedParent,
    string $registrationDomainName,
    int $registrationContactSettingsPrivacy,
    string $registrationContactSettingsRegistrantContactEmail,
    string $registrationContactSettingsRegistrantContactPhoneNumber,
    string $registrationContactSettingsAdminContactEmail,
    string $registrationContactSettingsAdminContactPhoneNumber,
    string $registrationContactSettingsTechnicalContactEmail,
    string $registrationContactSettingsTechnicalContactPhoneNumber
): void {
    // Create a client.
    $domainsClient = new DomainsClient();

    // Prepare the request message.
    $registrationContactSettingsRegistrantContactPostalAddress = new PostalAddress();
    $registrationContactSettingsRegistrantContact = (new Contact())
        ->setPostalAddress($registrationContactSettingsRegistrantContactPostalAddress)
        ->setEmail($registrationContactSettingsRegistrantContactEmail)
        ->setPhoneNumber($registrationContactSettingsRegistrantContactPhoneNumber);
    $registrationContactSettingsAdminContactPostalAddress = new PostalAddress();
    $registrationContactSettingsAdminContact = (new Contact())
        ->setPostalAddress($registrationContactSettingsAdminContactPostalAddress)
        ->setEmail($registrationContactSettingsAdminContactEmail)
        ->setPhoneNumber($registrationContactSettingsAdminContactPhoneNumber);
    $registrationContactSettingsTechnicalContactPostalAddress = new PostalAddress();
    $registrationContactSettingsTechnicalContact = (new Contact())
        ->setPostalAddress($registrationContactSettingsTechnicalContactPostalAddress)
        ->setEmail($registrationContactSettingsTechnicalContactEmail)
        ->setPhoneNumber($registrationContactSettingsTechnicalContactPhoneNumber);
    $registrationContactSettings = (new ContactSettings())
        ->setPrivacy($registrationContactSettingsPrivacy)
        ->setRegistrantContact($registrationContactSettingsRegistrantContact)
        ->setAdminContact($registrationContactSettingsAdminContact)
        ->setTechnicalContact($registrationContactSettingsTechnicalContact);
    $registration = (new Registration())
        ->setDomainName($registrationDomainName)
        ->setContactSettings($registrationContactSettings);
    $yearlyPrice = new Money();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $domainsClient->registerDomain($formattedParent, $registration, $yearlyPrice);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Registration $result */
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
    $formattedParent = DomainsClient::locationName('[PROJECT]', '[LOCATION]');
    $registrationDomainName = '[DOMAIN_NAME]';
    $registrationContactSettingsPrivacy = ContactPrivacy::CONTACT_PRIVACY_UNSPECIFIED;
    $registrationContactSettingsRegistrantContactEmail = '[EMAIL]';
    $registrationContactSettingsRegistrantContactPhoneNumber = '[PHONE_NUMBER]';
    $registrationContactSettingsAdminContactEmail = '[EMAIL]';
    $registrationContactSettingsAdminContactPhoneNumber = '[PHONE_NUMBER]';
    $registrationContactSettingsTechnicalContactEmail = '[EMAIL]';
    $registrationContactSettingsTechnicalContactPhoneNumber = '[PHONE_NUMBER]';

    register_domain_sample(
        $formattedParent,
        $registrationDomainName,
        $registrationContactSettingsPrivacy,
        $registrationContactSettingsRegistrantContactEmail,
        $registrationContactSettingsRegistrantContactPhoneNumber,
        $registrationContactSettingsAdminContactEmail,
        $registrationContactSettingsAdminContactPhoneNumber,
        $registrationContactSettingsTechnicalContactEmail,
        $registrationContactSettingsTechnicalContactPhoneNumber
    );
}
// [END domains_v1beta1_generated_Domains_RegisterDomain_sync]
