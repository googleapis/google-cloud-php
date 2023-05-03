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

// [START cloudchannel_v1_generated_CloudChannelService_UpdateChannelPartnerRepricingConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\ChannelPartnerRepricingConfig;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\RebillingBasis;
use Google\Cloud\Channel\V1\RepricingAdjustment;
use Google\Cloud\Channel\V1\RepricingConfig;
use Google\Type\Date;

/**
 * Updates a ChannelPartnerRepricingConfig. Call this method to set
 * modifications for a specific ChannelPartner's bill. This method overwrites
 * the existing CustomerRepricingConfig.
 *
 * You can only update configs if the
 * [RepricingConfig.effective_invoice_month][google.cloud.channel.v1.RepricingConfig.effective_invoice_month]
 * is a future month. To make changes to configs for the current month, use
 * [CreateChannelPartnerRepricingConfig][google.cloud.channel.v1.CloudChannelService.CreateChannelPartnerRepricingConfig],
 * taking note of its restrictions. You cannot update the
 * [RepricingConfig.effective_invoice_month][google.cloud.channel.v1.RepricingConfig.effective_invoice_month].
 *
 * When updating a config in the future:
 *
 * * This config must already exist.
 *
 * Possible Error Codes:
 *
 * * PERMISSION_DENIED: If the account making the request and the account
 * being queried are different.
 * * INVALID_ARGUMENT: Missing or invalid required parameters in the
 * request. Also displays if the updated config is for the current month or
 * past months.
 * * NOT_FOUND: The
 * [ChannelPartnerRepricingConfig][google.cloud.channel.v1.ChannelPartnerRepricingConfig]
 * specified does not exist or is not associated with the given account.
 * * INTERNAL: Any non-user error related to technical issues in the
 * backend. In this case, contact Cloud Channel support.
 *
 * Return Value:
 * If successful, the updated
 * [ChannelPartnerRepricingConfig][google.cloud.channel.v1.ChannelPartnerRepricingConfig]
 * resource, otherwise returns an error.
 *
 * @param int $channelPartnerRepricingConfigRepricingConfigRebillingBasis The [RebillingBasis][google.cloud.channel.v1.RebillingBasis] to
 *                                                                        use for this bill. Specifies the relative cost based on repricing costs you
 *                                                                        will apply.
 */
function update_channel_partner_repricing_config_sample(
    int $channelPartnerRepricingConfigRepricingConfigRebillingBasis
): void {
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $channelPartnerRepricingConfigRepricingConfigEffectiveInvoiceMonth = new Date();
    $channelPartnerRepricingConfigRepricingConfigAdjustment = new RepricingAdjustment();
    $channelPartnerRepricingConfigRepricingConfig = (new RepricingConfig())
        ->setEffectiveInvoiceMonth($channelPartnerRepricingConfigRepricingConfigEffectiveInvoiceMonth)
        ->setAdjustment($channelPartnerRepricingConfigRepricingConfigAdjustment)
        ->setRebillingBasis($channelPartnerRepricingConfigRepricingConfigRebillingBasis);
    $channelPartnerRepricingConfig = (new ChannelPartnerRepricingConfig())
        ->setRepricingConfig($channelPartnerRepricingConfigRepricingConfig);

    // Call the API and handle any network failures.
    try {
        /** @var ChannelPartnerRepricingConfig $response */
        $response = $cloudChannelServiceClient->updateChannelPartnerRepricingConfig(
            $channelPartnerRepricingConfig
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
    $channelPartnerRepricingConfigRepricingConfigRebillingBasis = RebillingBasis::REBILLING_BASIS_UNSPECIFIED;

    update_channel_partner_repricing_config_sample(
        $channelPartnerRepricingConfigRepricingConfigRebillingBasis
    );
}
// [END cloudchannel_v1_generated_CloudChannelService_UpdateChannelPartnerRepricingConfig_sync]
