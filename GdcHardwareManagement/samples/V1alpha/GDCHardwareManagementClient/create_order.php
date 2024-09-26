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

// [START gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_CreateOrder_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GdcHardwareManagement\V1alpha\Client\GDCHardwareManagementClient;
use Google\Cloud\GdcHardwareManagement\V1alpha\Contact;
use Google\Cloud\GdcHardwareManagement\V1alpha\CreateOrderRequest;
use Google\Cloud\GdcHardwareManagement\V1alpha\Order;
use Google\Cloud\GdcHardwareManagement\V1alpha\OrganizationContact;
use Google\Protobuf\Timestamp;
use Google\Rpc\Status;
use Google\Type\PostalAddress;

/**
 * Creates a new order in a given project and location.
 *
 * @param string $formattedParent                           The project and location to create the order in.
 *                                                          Format: `projects/{project}/locations/{location}`
 *                                                          Please see {@see GDCHardwareManagementClient::locationName()} for help formatting this field.
 * @param string $orderOrganizationContactContactsGivenName Given name of the contact.
 * @param string $orderOrganizationContactContactsEmail     Email of the contact.
 * @param string $orderOrganizationContactContactsPhone     Phone number of the contact.
 * @param string $orderCustomerMotivation                   Information about the customer's motivation for this order. The
 *                                                          length of this field must be <= 1000 characters.
 * @param string $orderRegionCode                           [Unicode CLDR](http://cldr.unicode.org/) region code where this
 *                                                          order will be deployed. For a list of valid CLDR region codes, see the
 *                                                          [Language Subtag
 *                                                          Registry](https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry).
 * @param string $orderBillingId                            The Google Cloud Billing ID to be charged for this order.
 */
function create_order_sample(
    string $formattedParent,
    string $orderOrganizationContactContactsGivenName,
    string $orderOrganizationContactContactsEmail,
    string $orderOrganizationContactContactsPhone,
    string $orderCustomerMotivation,
    string $orderRegionCode,
    string $orderBillingId
): void {
    // Create a client.
    $gDCHardwareManagementClient = new GDCHardwareManagementClient();

    // Prepare the request message.
    $orderOrganizationContactAddress = new PostalAddress();
    $contact = (new Contact())
        ->setGivenName($orderOrganizationContactContactsGivenName)
        ->setEmail($orderOrganizationContactContactsEmail)
        ->setPhone($orderOrganizationContactContactsPhone);
    $orderOrganizationContactContacts = [$contact,];
    $orderOrganizationContact = (new OrganizationContact())
        ->setAddress($orderOrganizationContactAddress)
        ->setContacts($orderOrganizationContactContacts);
    $orderFulfillmentTime = new Timestamp();
    $order = (new Order())
        ->setOrganizationContact($orderOrganizationContact)
        ->setCustomerMotivation($orderCustomerMotivation)
        ->setFulfillmentTime($orderFulfillmentTime)
        ->setRegionCode($orderRegionCode)
        ->setBillingId($orderBillingId);
    $request = (new CreateOrderRequest())
        ->setParent($formattedParent)
        ->setOrder($order);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gDCHardwareManagementClient->createOrder($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Order $result */
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
    $orderOrganizationContactContactsGivenName = '[GIVEN_NAME]';
    $orderOrganizationContactContactsEmail = '[EMAIL]';
    $orderOrganizationContactContactsPhone = '[PHONE]';
    $orderCustomerMotivation = '[CUSTOMER_MOTIVATION]';
    $orderRegionCode = '[REGION_CODE]';
    $orderBillingId = '[BILLING_ID]';

    create_order_sample(
        $formattedParent,
        $orderOrganizationContactContactsGivenName,
        $orderOrganizationContactContactsEmail,
        $orderOrganizationContactContactsPhone,
        $orderCustomerMotivation,
        $orderRegionCode,
        $orderBillingId
    );
}
// [END gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_CreateOrder_sync]
