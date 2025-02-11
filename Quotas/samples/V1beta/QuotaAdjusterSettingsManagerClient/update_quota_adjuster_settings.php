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

// [START cloudquotas_v1beta_generated_QuotaAdjusterSettingsManager_UpdateQuotaAdjusterSettings_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudQuotas\V1beta\Client\QuotaAdjusterSettingsManagerClient;
use Google\Cloud\CloudQuotas\V1beta\QuotaAdjusterSettings;
use Google\Cloud\CloudQuotas\V1beta\QuotaAdjusterSettings\Enablement;
use Google\Cloud\CloudQuotas\V1beta\UpdateQuotaAdjusterSettingsRequest;

/**
 * RPC Method for updating QuotaAdjusterSettings based on the request
 *
 * @param int $quotaAdjusterSettingsEnablement The configured value of the enablement at the given resource.
 */
function update_quota_adjuster_settings_sample(int $quotaAdjusterSettingsEnablement): void
{
    // Create a client.
    $quotaAdjusterSettingsManagerClient = new QuotaAdjusterSettingsManagerClient();

    // Prepare the request message.
    $quotaAdjusterSettings = (new QuotaAdjusterSettings())
        ->setEnablement($quotaAdjusterSettingsEnablement);
    $request = (new UpdateQuotaAdjusterSettingsRequest())
        ->setQuotaAdjusterSettings($quotaAdjusterSettings);

    // Call the API and handle any network failures.
    try {
        /** @var QuotaAdjusterSettings $response */
        $response = $quotaAdjusterSettingsManagerClient->updateQuotaAdjusterSettings($request);
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
    $quotaAdjusterSettingsEnablement = Enablement::ENABLEMENT_UNSPECIFIED;

    update_quota_adjuster_settings_sample($quotaAdjusterSettingsEnablement);
}
// [END cloudquotas_v1beta_generated_QuotaAdjusterSettingsManager_UpdateQuotaAdjusterSettings_sync]
