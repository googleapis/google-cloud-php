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

// [START cloudchannel_v1_generated_CloudChannelService_ListChannelPartnerRepricingConfigs_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Channel\V1\ChannelPartnerRepricingConfig;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;

/**
 * Lists information about how a Reseller modifies their bill before sending
 * it to a ChannelPartner.
 *
 * Possible Error Codes:
 *
 * * PERMISSION_DENIED: If the account making the request and the account
 * being queried are different.
 * * NOT_FOUND: The
 * [ChannelPartnerRepricingConfig][google.cloud.channel.v1.ChannelPartnerRepricingConfig]
 * specified does not exist or is not associated with the given account.
 * * INTERNAL: Any non-user error related to technical issues in the
 * backend. In this case, contact Cloud Channel support.
 *
 * Return Value:
 * If successful, the
 * [ChannelPartnerRepricingConfig][google.cloud.channel.v1.ChannelPartnerRepricingConfig]
 * resources. The data for each resource is displayed in the ascending order
 * of:
 *
 * * Channel Partner ID
 * * [RepricingConfig.effective_invoice_month][google.cloud.channel.v1.RepricingConfig.effective_invoice_month]
 * * [ChannelPartnerRepricingConfig.update_time][google.cloud.channel.v1.ChannelPartnerRepricingConfig.update_time]
 *
 * If unsuccessful, returns an error.
 *
 * @param string $formattedParent The resource name of the account's
 *                                [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink]. Parent
 *                                uses the format:
 *                                accounts/{account_id}/channelPartnerLinks/{channel_partner_id}.
 *                                Supports accounts/{account_id}/channelPartnerLinks/- to retrieve configs
 *                                for all channel partners. Please see
 *                                {@see CloudChannelServiceClient::channelPartnerLinkName()} for help formatting this field.
 */
function list_channel_partner_repricing_configs_sample(string $formattedParent): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $cloudChannelServiceClient->listChannelPartnerRepricingConfigs($formattedParent);

        /** @var ChannelPartnerRepricingConfig $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = CloudChannelServiceClient::channelPartnerLinkName(
        '[ACCOUNT]',
        '[CHANNEL_PARTNER_LINK]'
    );

    list_channel_partner_repricing_configs_sample($formattedParent);
}
// [END cloudchannel_v1_generated_CloudChannelService_ListChannelPartnerRepricingConfigs_sync]
