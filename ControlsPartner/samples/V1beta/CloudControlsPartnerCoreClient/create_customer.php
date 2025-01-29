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

// [START cloudcontrolspartner_v1beta_generated_CloudControlsPartnerCore_CreateCustomer_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudControlsPartner\V1beta\Client\CloudControlsPartnerCoreClient;
use Google\Cloud\CloudControlsPartner\V1beta\CreateCustomerRequest;
use Google\Cloud\CloudControlsPartner\V1beta\Customer;

/**
 * Creates a new customer.
 *
 * @param string $formattedParent     Parent resource
 *                                    Format: `organizations/{organization}/locations/{location}`
 *                                    Please see {@see CloudControlsPartnerCoreClient::organizationLocationName()} for help formatting this field.
 * @param string $customerDisplayName Display name for the customer
 * @param string $customerId          The customer id to use for the customer, which will become the
 *                                    final component of the customer's resource name. The specified value must
 *                                    be a valid Google cloud organization id.
 */
function create_customer_sample(
    string $formattedParent,
    string $customerDisplayName,
    string $customerId
): void {
    // Create a client.
    $cloudControlsPartnerCoreClient = new CloudControlsPartnerCoreClient();

    // Prepare the request message.
    $customer = (new Customer())
        ->setDisplayName($customerDisplayName);
    $request = (new CreateCustomerRequest())
        ->setParent($formattedParent)
        ->setCustomer($customer)
        ->setCustomerId($customerId);

    // Call the API and handle any network failures.
    try {
        /** @var Customer $response */
        $response = $cloudControlsPartnerCoreClient->createCustomer($request);
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
    $formattedParent = CloudControlsPartnerCoreClient::organizationLocationName(
        '[ORGANIZATION]',
        '[LOCATION]'
    );
    $customerDisplayName = '[DISPLAY_NAME]';
    $customerId = '[CUSTOMER_ID]';

    create_customer_sample($formattedParent, $customerDisplayName, $customerId);
}
// [END cloudcontrolspartner_v1beta_generated_CloudControlsPartnerCore_CreateCustomer_sync]
