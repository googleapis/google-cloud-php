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

// [START cloudchannel_v1_generated_CloudChannelService_CreateCustomerRepricingConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\CustomerRepricingConfig;
use Google\Cloud\Channel\V1\RebillingBasis;
use Google\Cloud\Channel\V1\RepricingAdjustment;
use Google\Cloud\Channel\V1\RepricingConfig;
use Google\Type\Date;

/**
 * Creates a CustomerRepricingConfig. Call this method to set modifications
 * for a specific customer's bill. You can only create configs if the
 * [RepricingConfig.effective_invoice_month][google.cloud.channel.v1.RepricingConfig.effective_invoice_month]
 * is a future month. If needed, you can create a config for the current
 * month, with some restrictions.
 *
 * When creating a config for a future month, make sure there are no existing
 * configs for that
 * [RepricingConfig.effective_invoice_month][google.cloud.channel.v1.RepricingConfig.effective_invoice_month].
 *
 * The following restrictions are for creating configs in the current month.
 *
 * * This functionality is reserved for recovering from an erroneous config,
 * and should not be used for regular business cases.
 * * The new config will not modify exports used with other configs.
 * Changes to the config may be immediate, but may take up to 24 hours.
 * * There is a limit of ten configs for any
 * [RepricingConfig.EntitlementGranularity.entitlement][google.cloud.channel.v1.RepricingConfig.EntitlementGranularity.entitlement]
 * or
 * [RepricingConfig.effective_invoice_month][google.cloud.channel.v1.RepricingConfig.effective_invoice_month].
 * * The contained
 * [CustomerRepricingConfig.repricing_config][google.cloud.channel.v1.CustomerRepricingConfig.repricing_config]
 * vaule must be different from the value used in the current config for a
 * [RepricingConfig.EntitlementGranularity.entitlement][google.cloud.channel.v1.RepricingConfig.EntitlementGranularity.entitlement].
 *
 * Possible Error Codes:
 *
 * * PERMISSION_DENIED: If the account making the request and the account
 * being queried are different.
 * * INVALID_ARGUMENT: Missing or invalid required parameters in the
 * request. Also displays if the updated config is for the current month or
 * past months.
 * * NOT_FOUND: The
 * [CustomerRepricingConfig][google.cloud.channel.v1.CustomerRepricingConfig]
 * specified does not exist or is not associated with the given account.
 * * INTERNAL: Any non-user error related to technical issues in the
 * backend. In this case, contact Cloud Channel support.
 *
 * Return Value:
 * If successful, the updated
 * [CustomerRepricingConfig][google.cloud.channel.v1.CustomerRepricingConfig]
 * resource, otherwise returns an error.
 *
 * @param string $formattedParent                                      The resource name of the customer that will receive this
 *                                                                     repricing config. Parent uses the format:
 *                                                                     accounts/{account_id}/customers/{customer_id}
 *                                                                     Please see {@see CloudChannelServiceClient::customerName()} for help formatting this field.
 * @param int    $customerRepricingConfigRepricingConfigRebillingBasis The [RebillingBasis][google.cloud.channel.v1.RebillingBasis] to
 *                                                                     use for this bill. Specifies the relative cost based on repricing costs you
 *                                                                     will apply.
 */
function create_customer_repricing_config_sample(
    string $formattedParent,
    int $customerRepricingConfigRepricingConfigRebillingBasis
): void {
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $customerRepricingConfigRepricingConfigEffectiveInvoiceMonth = new Date();
    $customerRepricingConfigRepricingConfigAdjustment = new RepricingAdjustment();
    $customerRepricingConfigRepricingConfig = (new RepricingConfig())
        ->setEffectiveInvoiceMonth($customerRepricingConfigRepricingConfigEffectiveInvoiceMonth)
        ->setAdjustment($customerRepricingConfigRepricingConfigAdjustment)
        ->setRebillingBasis($customerRepricingConfigRepricingConfigRebillingBasis);
    $customerRepricingConfig = (new CustomerRepricingConfig())
        ->setRepricingConfig($customerRepricingConfigRepricingConfig);

    // Call the API and handle any network failures.
    try {
        /** @var CustomerRepricingConfig $response */
        $response = $cloudChannelServiceClient->createCustomerRepricingConfig(
            $formattedParent,
            $customerRepricingConfig
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
    $formattedParent = CloudChannelServiceClient::customerName('[ACCOUNT]', '[CUSTOMER]');
    $customerRepricingConfigRepricingConfigRebillingBasis = RebillingBasis::REBILLING_BASIS_UNSPECIFIED;

    create_customer_repricing_config_sample(
        $formattedParent,
        $customerRepricingConfigRepricingConfigRebillingBasis
    );
}
// [END cloudchannel_v1_generated_CloudChannelService_CreateCustomerRepricingConfig_sync]
