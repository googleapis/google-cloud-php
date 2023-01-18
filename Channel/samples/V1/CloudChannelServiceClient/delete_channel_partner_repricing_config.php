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

// [START cloudchannel_v1_generated_CloudChannelService_DeleteChannelPartnerRepricingConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;

/**
 * Deletes the given
 * [ChannelPartnerRepricingConfig][google.cloud.channel.v1.ChannelPartnerRepricingConfig]
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
 * [ChannelPartnerRepricingConfig][google.cloud.channel.v1.ChannelPartnerRepricingConfig]
 * is active or in the past.
 * * NOT_FOUND: No
 * [ChannelPartnerRepricingConfig][google.cloud.channel.v1.ChannelPartnerRepricingConfig]
 * found for the name in the request.
 *
 * @param string $formattedName The resource name of the channel partner repricing config rule to
 *                              delete. Please see
 *                              {@see CloudChannelServiceClient::channelPartnerRepricingConfigName()} for help formatting this field.
 */
function delete_channel_partner_repricing_config_sample(string $formattedName): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Call the API and handle any network failures.
    try {
        $cloudChannelServiceClient->deleteChannelPartnerRepricingConfig($formattedName);
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
    $formattedName = CloudChannelServiceClient::channelPartnerRepricingConfigName(
        '[ACCOUNT]',
        '[CHANNEL_PARTNER]',
        '[CHANNEL_PARTNER_REPRICING_CONFIG]'
    );

    delete_channel_partner_repricing_config_sample($formattedName);
}
// [END cloudchannel_v1_generated_CloudChannelService_DeleteChannelPartnerRepricingConfig_sync]
