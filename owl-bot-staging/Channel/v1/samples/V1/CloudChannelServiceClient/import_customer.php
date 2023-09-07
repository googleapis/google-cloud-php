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

// [START cloudchannel_v1_generated_CloudChannelService_ImportCustomer_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\Customer;
use Google\Cloud\Channel\V1\ImportCustomerRequest\CustomerIdentityOneof;

/**
 * Imports a [Customer][google.cloud.channel.v1.Customer] from the Cloud
 * Identity associated with the provided Cloud Identity ID or domain before a
 * TransferEntitlements call. If a linked Customer already exists and
 * overwrite_if_exists is true, it will update that Customer's data.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED:
 * * The reseller account making the request is different from the
 * reseller account in the API request.
 * * You are not authorized to import the customer. See
 * https://support.google.com/channelservices/answer/9759265
 * * NOT_FOUND: Cloud Identity doesn't exist or was deleted.
 * * INVALID_ARGUMENT: Required parameters are missing, or the auth_token is
 * expired or invalid.
 * * ALREADY_EXISTS: A customer already exists and has conflicting critical
 * fields. Requires an overwrite.
 *
 * Return value:
 * The [Customer][google.cloud.channel.v1.Customer].
 *
 * @param string $customerIdentityDomain Customer domain.
 * @param string $parent                 The resource name of the reseller's account.
 *                                       Parent takes the format: accounts/{account_id} or
 *                                       accounts/{account_id}/channelPartnerLinks/{channel_partner_id}
 * @param bool   $overwriteIfExists      Choose to overwrite an existing customer if found.
 *                                       This must be set to true if there is an existing customer with a
 *                                       conflicting region code or domain.
 */
function import_customer_sample(
    string $customerIdentityDomain,
    string $parent,
    bool $overwriteIfExists
): void {
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $customerIdentity = (new CustomerIdentityOneof())
        ->setDomain($customerIdentityDomain);

    // Call the API and handle any network failures.
    try {
        /** @var Customer $response */
        $response = $cloudChannelServiceClient->importCustomer(
            $customerIdentity,
            $parent,
            $overwriteIfExists
        );
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
    $customerIdentityDomain = '[DOMAIN]';
    $parent = '[PARENT]';
    $overwriteIfExists = false;

    import_customer_sample($customerIdentityDomain, $parent, $overwriteIfExists);
}
// [END cloudchannel_v1_generated_CloudChannelService_ImportCustomer_sync]
