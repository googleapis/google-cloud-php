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

// [START monitoring_v3_generated_AlertPolicyService_ListAlertPolicies_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Monitoring\V3\AlertPolicy;
use Google\Cloud\Monitoring\V3\Client\AlertPolicyServiceClient;
use Google\Cloud\Monitoring\V3\ListAlertPoliciesRequest;

/**
 * Lists the existing alerting policies for the workspace.
 *
 * @param string $name The
 *                     [project](https://cloud.google.com/monitoring/api/v3#project_name) whose
 *                     alert policies are to be listed. The format is:
 *
 *                     projects/[PROJECT_ID_OR_NUMBER]
 *
 *                     Note that this field names the parent container in which the alerting
 *                     policies to be listed are stored. To retrieve a single alerting policy
 *                     by name, use the
 *                     [GetAlertPolicy][google.monitoring.v3.AlertPolicyService.GetAlertPolicy]
 *                     operation, instead.
 */
function list_alert_policies_sample(string $name): void
{
    // Create a client.
    $alertPolicyServiceClient = new AlertPolicyServiceClient();

    // Prepare the request message.
    $request = (new ListAlertPoliciesRequest())
        ->setName($name);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $alertPolicyServiceClient->listAlertPolicies($request);

        /** @var AlertPolicy $element */
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
    $name = '[NAME]';

    list_alert_policies_sample($name);
}
// [END monitoring_v3_generated_AlertPolicyService_ListAlertPolicies_sync]
