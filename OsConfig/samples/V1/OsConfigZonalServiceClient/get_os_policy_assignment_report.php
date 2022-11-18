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

// [START osconfig_v1_generated_OsConfigZonalService_GetOSPolicyAssignmentReport_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\OsConfig\V1\OSPolicyAssignmentReport;
use Google\Cloud\OsConfig\V1\OsConfigZonalServiceClient;

/**
 * Get the OS policy asssignment report for the specified Compute Engine VM
 * instance.
 *
 * @param string $formattedName API resource name for OS policy assignment report.
 *
 *                              Format:
 *                              `/projects/{project}/locations/{location}/instances/{instance}/osPolicyAssignments/{assignment}/report`
 *
 *                              For `{project}`, either `project-number` or `project-id` can be provided.
 *                              For `{instance_id}`, either Compute Engine `instance-id` or `instance-name`
 *                              can be provided.
 *                              For `{assignment_id}`, the OSPolicyAssignment id must be provided. Please see
 *                              {@see OsConfigZonalServiceClient::oSPolicyAssignmentReportName()} for help formatting this field.
 */
function get_os_policy_assignment_report_sample(string $formattedName): void
{
    // Create a client.
    $osConfigZonalServiceClient = new OsConfigZonalServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OSPolicyAssignmentReport $response */
        $response = $osConfigZonalServiceClient->getOSPolicyAssignmentReport($formattedName);
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
    $formattedName = OsConfigZonalServiceClient::oSPolicyAssignmentReportName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]',
        '[ASSIGNMENT]'
    );

    get_os_policy_assignment_report_sample($formattedName);
}
// [END osconfig_v1_generated_OsConfigZonalService_GetOSPolicyAssignmentReport_sync]
