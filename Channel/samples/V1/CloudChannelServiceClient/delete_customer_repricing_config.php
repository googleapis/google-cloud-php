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

// [START cloudchannel_v1_generated_CloudChannelService_DeleteCustomerRepricingConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\DeleteCustomerRepricingConfigRequest;

/**
 * Deletes the given
 * [CustomerRepricingConfig][google.cloud.channel.v1.CustomerRepricingConfig]
 * permanently. You can only delete configs if their
 * [RepricingConfig.effective_invoice_month][google.cloud.channel.v1.RepricingConfig.effective_invoice_month]
 * is set to a date after the current month.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The account making the request does not own
 * this customer.
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 * * FAILED_PRECONDITION: The
 * [CustomerRepricingConfig][google.cloud.channel.v1.CustomerRepricingConfig]
 * is active or in the past.
 * * NOT_FOUND: No
 * [CustomerRepricingConfig][google.cloud.channel.v1.CustomerRepricingConfig]
 * found for the name in the request.
 *
 * @param string $formattedName The resource name of the customer repricing config rule to
 *                              delete. Format:
 *                              accounts/{account_id}/customers/{customer_id}/customerRepricingConfigs/{id}. Please see
 *                              {@see CloudChannelServiceClient::customerRepricingConfigName()} for help formatting this field.
 */
function delete_customer_repricing_config_sample(string $formattedName): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $request = (new DeleteCustomerRepricingConfigRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $cloudChannelServiceClient->deleteCustomerRepricingConfig($request);
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
    $formattedName = CloudChannelServiceClient::customerRepricingConfigName(
        '[ACCOUNT]',
        '[CUSTOMER]',
        '[CUSTOMER_REPRICING_CONFIG]'
    );

    delete_customer_repricing_config_sample($formattedName);
}
// [END cloudchannel_v1_generated_CloudChannelService_DeleteCustomerRepricingConfig_sync]
