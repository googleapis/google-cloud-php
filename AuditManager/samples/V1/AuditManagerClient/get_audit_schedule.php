<?php
/*
 * Copyright 2026 Google LLC
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

// [START auditmanager_v1_generated_AuditManager_GetAuditSchedule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AuditManager\V1\AuditSchedule;
use Google\Cloud\AuditManager\V1\Client\AuditManagerClient;
use Google\Cloud\AuditManager\V1\GetAuditScheduleRequest;

/**
 * Gets details of a single audit schedule.
 *
 * @param string $formattedName Name of the audit schedule to retrieve, in one of the following
 *                              formats:
 *
 *                              * `projects/{project}/locations/{location}/auditSchedules/{audit_schedule}`
 *                              * `folders/{folder}/locations/{location}/auditSchedules/{audit_schedule}`
 *                              * `organizations/{organization}/locations/{location}/auditSchedules/{audit_schedule}`
 *                              Please see {@see AuditManagerClient::auditScheduleName()} for help formatting this field.
 */
function get_audit_schedule_sample(string $formattedName): void
{
    // Create a client.
    $auditManagerClient = new AuditManagerClient();

    // Prepare the request message.
    $request = (new GetAuditScheduleRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var AuditSchedule $response */
        $response = $auditManagerClient->getAuditSchedule($request);
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
    $formattedName = AuditManagerClient::auditScheduleName(
        '[PROJECT]',
        '[LOCATION]',
        '[AUDIT_SCHEDULE]'
    );

    get_audit_schedule_sample($formattedName);
}
// [END auditmanager_v1_generated_AuditManager_GetAuditSchedule_sync]
