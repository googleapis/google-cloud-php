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

// [START monitoring_v3_generated_AlertPolicyService_DeleteAlertPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Monitoring\V3\Client\AlertPolicyServiceClient;
use Google\Cloud\Monitoring\V3\DeleteAlertPolicyRequest;

/**
 * Deletes an alerting policy.
 *
 * Design your application to single-thread API calls that modify the state of
 * alerting policies in a single project. This includes calls to
 * CreateAlertPolicy, DeleteAlertPolicy and UpdateAlertPolicy.
 *
 * @param string $formattedName The alerting policy to delete. The format is:
 *
 *                              projects/[PROJECT_ID_OR_NUMBER]/alertPolicies/[ALERT_POLICY_ID]
 *
 *                              For more information, see [AlertPolicy][google.monitoring.v3.AlertPolicy]. Please see
 *                              {@see AlertPolicyServiceClient::alertPolicyName()} for help formatting this field.
 */
function delete_alert_policy_sample(string $formattedName): void
{
    // Create a client.
    $alertPolicyServiceClient = new AlertPolicyServiceClient();

    // Prepare the request message.
    $request = (new DeleteAlertPolicyRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $alertPolicyServiceClient->deleteAlertPolicy($request);
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
    $formattedName = AlertPolicyServiceClient::alertPolicyName('[PROJECT]', '[ALERT_POLICY]');

    delete_alert_policy_sample($formattedName);
}
// [END monitoring_v3_generated_AlertPolicyService_DeleteAlertPolicy_sync]
