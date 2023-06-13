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

// [START migrationcenter_v1_generated_MigrationCenter_CreateReportConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\MigrationCenter\V1\Client\MigrationCenterClient;
use Google\Cloud\MigrationCenter\V1\CreateReportConfigRequest;
use Google\Cloud\MigrationCenter\V1\ReportConfig;
use Google\Cloud\MigrationCenter\V1\ReportConfig\GroupPreferenceSetAssignment;
use Google\Rpc\Status;

/**
 * Creates a report configuration.
 *
 * @param string $formattedParent                                                 Value for parent. Please see
 *                                                                                {@see MigrationCenterClient::locationName()} for help formatting this field.
 * @param string $reportConfigId                                                  User specified ID for the report config. It will become the last
 *                                                                                component of the report config name. The ID must be unique within the
 *                                                                                project, must conform with RFC-1034, is restricted to lower-cased letters,
 *                                                                                and has a maximum length of 63 characters. The ID must match the regular
 *                                                                                expression: [a-z]([a-z0-9-]{0,61}[a-z0-9])?.
 * @param string $formattedReportConfigGroupPreferencesetAssignmentsGroup         Name of the group. Please see
 *                                                                                {@see MigrationCenterClient::groupName()} for help formatting this field.
 * @param string $formattedReportConfigGroupPreferencesetAssignmentsPreferenceSet Name of the Preference Set. Please see
 *                                                                                {@see MigrationCenterClient::preferenceSetName()} for help formatting this field.
 */
function create_report_config_sample(
    string $formattedParent,
    string $reportConfigId,
    string $formattedReportConfigGroupPreferencesetAssignmentsGroup,
    string $formattedReportConfigGroupPreferencesetAssignmentsPreferenceSet
): void {
    // Create a client.
    $migrationCenterClient = new MigrationCenterClient();

    // Prepare the request message.
    $groupPreferenceSetAssignment = (new GroupPreferenceSetAssignment())
        ->setGroup($formattedReportConfigGroupPreferencesetAssignmentsGroup)
        ->setPreferenceSet($formattedReportConfigGroupPreferencesetAssignmentsPreferenceSet);
    $reportConfigGroupPreferencesetAssignments = [$groupPreferenceSetAssignment,];
    $reportConfig = (new ReportConfig())
        ->setGroupPreferencesetAssignments($reportConfigGroupPreferencesetAssignments);
    $request = (new CreateReportConfigRequest())
        ->setParent($formattedParent)
        ->setReportConfigId($reportConfigId)
        ->setReportConfig($reportConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $migrationCenterClient->createReportConfig($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ReportConfig $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedParent = MigrationCenterClient::locationName('[PROJECT]', '[LOCATION]');
    $reportConfigId = '[REPORT_CONFIG_ID]';
    $formattedReportConfigGroupPreferencesetAssignmentsGroup = MigrationCenterClient::groupName(
        '[PROJECT]',
        '[LOCATION]',
        '[GROUP]'
    );
    $formattedReportConfigGroupPreferencesetAssignmentsPreferenceSet = MigrationCenterClient::preferenceSetName(
        '[PROJECT]',
        '[LOCATION]',
        '[PREFERENCE_SET]'
    );

    create_report_config_sample(
        $formattedParent,
        $reportConfigId,
        $formattedReportConfigGroupPreferencesetAssignmentsGroup,
        $formattedReportConfigGroupPreferencesetAssignmentsPreferenceSet
    );
}
// [END migrationcenter_v1_generated_MigrationCenter_CreateReportConfig_sync]
