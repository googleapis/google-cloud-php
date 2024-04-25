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

// [START monitoring_v3_generated_AlertPolicyService_CreateAlertPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Monitoring\V3\AlertPolicy;
use Google\Cloud\Monitoring\V3\Client\AlertPolicyServiceClient;
use Google\Cloud\Monitoring\V3\CreateAlertPolicyRequest;

/**
 * Creates a new alerting policy.
 *
 * Design your application to single-thread API calls that modify the state of
 * alerting policies in a single project. This includes calls to
 * CreateAlertPolicy, DeleteAlertPolicy and UpdateAlertPolicy.
 *
 * @param string $name The
 *                     [project](https://cloud.google.com/monitoring/api/v3#project_name) in which
 *                     to create the alerting policy. The format is:
 *
 *                     projects/[PROJECT_ID_OR_NUMBER]
 *
 *                     Note that this field names the parent container in which the alerting
 *                     policy will be written, not the name of the created policy. |name| must be
 *                     a host project of a Metrics Scope, otherwise INVALID_ARGUMENT error will
 *                     return. The alerting policy that is returned will have a name that contains
 *                     a normalized representation of this name as a prefix but adds a suffix of
 *                     the form `/alertPolicies/[ALERT_POLICY_ID]`, identifying the policy in the
 *                     container.
 */
function create_alert_policy_sample(string $name): void
{
    // Create a client.
    $alertPolicyServiceClient = new AlertPolicyServiceClient();

    // Prepare the request message.
    $alertPolicy = new AlertPolicy();
    $request = (new CreateAlertPolicyRequest())
        ->setName($name)
        ->setAlertPolicy($alertPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var AlertPolicy $response */
        $response = $alertPolicyServiceClient->createAlertPolicy($request);
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
    $name = '[NAME]';

    create_alert_policy_sample($name);
}
// [END monitoring_v3_generated_AlertPolicyService_CreateAlertPolicy_sync]
