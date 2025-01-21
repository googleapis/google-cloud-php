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

// [START cloudquotas_v1beta_generated_CloudQuotas_CreateQuotaPreference_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudQuotas\V1beta\Client\CloudQuotasClient;
use Google\Cloud\CloudQuotas\V1beta\CreateQuotaPreferenceRequest;
use Google\Cloud\CloudQuotas\V1beta\QuotaConfig;
use Google\Cloud\CloudQuotas\V1beta\QuotaPreference;

/**
 * Creates a new QuotaPreference that declares the desired value for a quota.
 *
 * @param string $formattedParent                          Value for parent.
 *
 *                                                         Example:
 *                                                         `projects/123/locations/global`
 *                                                         Please see {@see CloudQuotasClient::locationName()} for help formatting this field.
 * @param int    $quotaPreferenceQuotaConfigPreferredValue The preferred value. Must be greater than or equal to -1. If set
 *                                                         to -1, it means the value is "unlimited".
 * @param string $quotaPreferenceService                   The name of the service to which the quota preference is applied.
 * @param string $quotaPreferenceQuotaId                   The id of the quota to which the quota preference is applied. A
 *                                                         quota name is unique in the service. Example: `CpusPerProjectPerRegion`
 */
function create_quota_preference_sample(
    string $formattedParent,
    int $quotaPreferenceQuotaConfigPreferredValue,
    string $quotaPreferenceService,
    string $quotaPreferenceQuotaId
): void {
    // Create a client.
    $cloudQuotasClient = new CloudQuotasClient();

    // Prepare the request message.
    $quotaPreferenceQuotaConfig = (new QuotaConfig())
        ->setPreferredValue($quotaPreferenceQuotaConfigPreferredValue);
    $quotaPreference = (new QuotaPreference())
        ->setQuotaConfig($quotaPreferenceQuotaConfig)
        ->setService($quotaPreferenceService)
        ->setQuotaId($quotaPreferenceQuotaId);
    $request = (new CreateQuotaPreferenceRequest())
        ->setParent($formattedParent)
        ->setQuotaPreference($quotaPreference);

    // Call the API and handle any network failures.
    try {
        /** @var QuotaPreference $response */
        $response = $cloudQuotasClient->createQuotaPreference($request);
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
    $formattedParent = CloudQuotasClient::locationName('[PROJECT]', '[LOCATION]');
    $quotaPreferenceQuotaConfigPreferredValue = 0;
    $quotaPreferenceService = '[SERVICE]';
    $quotaPreferenceQuotaId = '[QUOTA_ID]';

    create_quota_preference_sample(
        $formattedParent,
        $quotaPreferenceQuotaConfigPreferredValue,
        $quotaPreferenceService,
        $quotaPreferenceQuotaId
    );
}
// [END cloudquotas_v1beta_generated_CloudQuotas_CreateQuotaPreference_sync]
