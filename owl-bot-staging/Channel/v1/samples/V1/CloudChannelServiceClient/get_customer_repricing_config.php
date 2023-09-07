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

// [START cloudchannel_v1_generated_CloudChannelService_GetCustomerRepricingConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\CustomerRepricingConfig;

/**
 * Gets information about how a Reseller modifies their bill before sending
 * it to a Customer.
 *
 * Possible Error Codes:
 *
 * * PERMISSION_DENIED: If the account making the request and the account
 * being queried are different.
 * * NOT_FOUND: The
 * [CustomerRepricingConfig][google.cloud.channel.v1.CustomerRepricingConfig]
 * was not found.
 * * INTERNAL: Any non-user error related to technical issues in the
 * backend. In this case, contact Cloud Channel support.
 *
 * Return Value:
 * If successful, the
 * [CustomerRepricingConfig][google.cloud.channel.v1.CustomerRepricingConfig]
 * resource, otherwise returns an error.
 *
 * @param string $formattedName The resource name of the CustomerRepricingConfig.
 *                              Format:
 *                              accounts/{account_id}/customers/{customer_id}/customerRepricingConfigs/{id}. Please see
 *                              {@see CloudChannelServiceClient::customerRepricingConfigName()} for help formatting this field.
 */
function get_customer_repricing_config_sample(string $formattedName): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var CustomerRepricingConfig $response */
        $response = $cloudChannelServiceClient->getCustomerRepricingConfig($formattedName);
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
    $formattedName = CloudChannelServiceClient::customerRepricingConfigName(
        '[ACCOUNT]',
        '[CUSTOMER]',
        '[CUSTOMER_REPRICING_CONFIG]'
    );

    get_customer_repricing_config_sample($formattedName);
}
// [END cloudchannel_v1_generated_CloudChannelService_GetCustomerRepricingConfig_sync]
