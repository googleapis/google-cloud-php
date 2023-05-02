<?php
/*
 * Copyright 2023 Google LLC
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

// [START cloudchannel_v1_generated_CloudChannelService_UpdateCustomer_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\Customer;
use Google\Type\PostalAddress;

/**
 * Updates an existing [Customer][google.cloud.channel.v1.Customer] resource
 * for the reseller or distributor.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The reseller account making the request is different
 * from the reseller account in the API request.
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 * * NOT_FOUND: No [Customer][google.cloud.channel.v1.Customer] resource found
 * for the name in the request.
 *
 * Return value:
 * The updated [Customer][google.cloud.channel.v1.Customer] resource.
 *
 * @param string $customerOrgDisplayName Name of the organization that the customer entity represents.
 * @param string $customerDomain         The customer's primary domain. Must match the primary contact
 *                                       email's domain.
 */
function update_customer_sample(string $customerOrgDisplayName, string $customerDomain): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $customerOrgPostalAddress = new PostalAddress();
    $customer = (new Customer())
        ->setOrgDisplayName($customerOrgDisplayName)
        ->setOrgPostalAddress($customerOrgPostalAddress)
        ->setDomain($customerDomain);

    // Call the API and handle any network failures.
    try {
        /** @var Customer $response */
        $response = $cloudChannelServiceClient->updateCustomer($customer);
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
    $customerOrgDisplayName = '[ORG_DISPLAY_NAME]';
    $customerDomain = '[DOMAIN]';

    update_customer_sample($customerOrgDisplayName, $customerDomain);
}
// [END cloudchannel_v1_generated_CloudChannelService_UpdateCustomer_sync]
