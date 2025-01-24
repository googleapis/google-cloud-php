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

// [START cloudcontrolspartner_v1beta_generated_CloudControlsPartnerCore_UpdateCustomer_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudControlsPartner\V1beta\Client\CloudControlsPartnerCoreClient;
use Google\Cloud\CloudControlsPartner\V1beta\Customer;
use Google\Cloud\CloudControlsPartner\V1beta\UpdateCustomerRequest;

/**
 * Update details of a single customer
 *
 * @param string $customerDisplayName Display name for the customer
 */
function update_customer_sample(string $customerDisplayName): void
{
    // Create a client.
    $cloudControlsPartnerCoreClient = new CloudControlsPartnerCoreClient();

    // Prepare the request message.
    $customer = (new Customer())
        ->setDisplayName($customerDisplayName);
    $request = (new UpdateCustomerRequest())
        ->setCustomer($customer);

    // Call the API and handle any network failures.
    try {
        /** @var Customer $response */
        $response = $cloudControlsPartnerCoreClient->updateCustomer($request);
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
    $customerDisplayName = '[DISPLAY_NAME]';

    update_customer_sample($customerDisplayName);
}
// [END cloudcontrolspartner_v1beta_generated_CloudControlsPartnerCore_UpdateCustomer_sync]
