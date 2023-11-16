<?php
/*
 * Copyright 2022 Google LLC
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

// [START monitoring_v3_generated_AlertPolicyService_UpdateAlertPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Monitoring\V3\AlertPolicy;
use Google\Cloud\Monitoring\V3\AlertPolicyServiceClient;

/**
 * Updates an alerting policy. You can either replace the entire policy with
 * a new one or replace only certain fields in the current alerting policy by
 * specifying the fields to be updated via `updateMask`. Returns the
 * updated alerting policy.
 *
 * Design your application to single-thread API calls that modify the state of
 * alerting policies in a single project. This includes calls to
 * CreateAlertPolicy, DeleteAlertPolicy and UpdateAlertPolicy.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_alert_policy_sample(): void
{
    // Create a client.
    $alertPolicyServiceClient = new AlertPolicyServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $alertPolicy = new AlertPolicy();

    // Call the API and handle any network failures.
    try {
        /** @var AlertPolicy $response */
        $response = $alertPolicyServiceClient->updateAlertPolicy($alertPolicy);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END monitoring_v3_generated_AlertPolicyService_UpdateAlertPolicy_sync]
