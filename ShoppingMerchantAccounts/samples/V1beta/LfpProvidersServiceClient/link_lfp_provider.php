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

// [START merchantapi_v1beta_generated_LfpProvidersService_LinkLfpProvider_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1beta\Client\LfpProvidersServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\LinkLfpProviderRequest;
use Google\Shopping\Merchant\Accounts\V1beta\LinkLfpProviderResponse;

/**
 * Link the specified merchant to a LFP provider for the specified country.
 *
 * @param string $formattedName     The name of the LFP provider resource to link.
 *                                  Format:
 *                                  `accounts/{account}/omnichannelSettings/{omnichannel_setting}/lfpProviders/{lfp_provider}`.
 *                                  The `lfp_provider` is the LFP provider ID. Please see
 *                                  {@see LfpProvidersServiceClient::lfpProviderName()} for help formatting this field.
 * @param string $externalAccountId The external account ID by which this merchant is known to the
 *                                  LFP provider.
 */
function link_lfp_provider_sample(string $formattedName, string $externalAccountId): void
{
    // Create a client.
    $lfpProvidersServiceClient = new LfpProvidersServiceClient();

    // Prepare the request message.
    $request = (new LinkLfpProviderRequest())
        ->setName($formattedName)
        ->setExternalAccountId($externalAccountId);

    // Call the API and handle any network failures.
    try {
        /** @var LinkLfpProviderResponse $response */
        $response = $lfpProvidersServiceClient->linkLfpProvider($request);
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
    $formattedName = LfpProvidersServiceClient::lfpProviderName(
        '[ACCOUNT]',
        '[OMNICHANNEL_SETTING]',
        '[LFP_PROVIDER]'
    );
    $externalAccountId = '[EXTERNAL_ACCOUNT_ID]';

    link_lfp_provider_sample($formattedName, $externalAccountId);
}
// [END merchantapi_v1beta_generated_LfpProvidersService_LinkLfpProvider_sync]
