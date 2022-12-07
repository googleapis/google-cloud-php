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

// [START osconfig_v1_generated_OsConfigZonalService_ListOSPolicyAssignmentReports_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\OsConfig\V1\OSPolicyAssignmentReport;
use Google\Cloud\OsConfig\V1\OsConfigZonalServiceClient;

/**
 * List OS policy asssignment reports for all Compute Engine VM instances in
 * the specified zone.
 *
 * @param string $formattedParent The parent resource name.
 *
 *                                Format:
 *                                `projects/{project}/locations/{location}/instances/{instance}/osPolicyAssignments/{assignment}/reports`
 *
 *                                For `{project}`, either `project-number` or `project-id` can be provided.
 *                                For `{instance}`, either `instance-name`, `instance-id`, or `-` can be
 *                                provided. If '-' is provided, the response will include
 *                                OSPolicyAssignmentReports for all instances in the project/location.
 *                                For `{assignment}`, either `assignment-id` or `-` can be provided. If '-'
 *                                is provided, the response will include OSPolicyAssignmentReports for all
 *                                OSPolicyAssignments in the project/location.
 *                                Either {instance} or {assignment} must be `-`.
 *
 *                                For example:
 *                                `projects/{project}/locations/{location}/instances/{instance}/osPolicyAssignments/-/reports`
 *                                returns all reports for the instance
 *                                `projects/{project}/locations/{location}/instances/-/osPolicyAssignments/{assignment-id}/reports`
 *                                returns all the reports for the given assignment across all instances.
 *                                `projects/{project}/locations/{location}/instances/-/osPolicyAssignments/-/reports`
 *                                returns all the reports for all assignments across all instances. Please see
 *                                {@see OsConfigZonalServiceClient::instanceOSPolicyAssignmentName()} for help formatting this field.
 */
function list_os_policy_assignment_reports_sample(string $formattedParent): void
{
    // Create a client.
    $osConfigZonalServiceClient = new OsConfigZonalServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $osConfigZonalServiceClient->listOSPolicyAssignmentReports($formattedParent);

        /** @var OSPolicyAssignmentReport $element */
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
    $formattedParent = OsConfigZonalServiceClient::instanceOSPolicyAssignmentName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]',
        '[ASSIGNMENT]'
    );

    list_os_policy_assignment_reports_sample($formattedParent);
}
// [END osconfig_v1_generated_OsConfigZonalService_ListOSPolicyAssignmentReports_sync]
