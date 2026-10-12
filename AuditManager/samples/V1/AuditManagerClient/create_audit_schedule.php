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

// [START auditmanager_v1_generated_AuditManager_CreateAuditSchedule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AuditManager\V1\AuditSchedule;
use Google\Cloud\AuditManager\V1\AuditSchedule\AuditReportFormat;
use Google\Cloud\AuditManager\V1\Client\AuditManagerClient;
use Google\Cloud\AuditManager\V1\CreateAuditScheduleRequest;
use Google\Cloud\AuditManager\V1\ScheduleConfig;
use Google\Cloud\AuditManager\V1\ScheduleConfig\Frequency;
use Google\Protobuf\Timestamp;

/**
 * Creates a new audit schedule in a given project and location.
 *
 * @param string $formattedParent                      Project or folder that this audit schedule is for, in one of the
 *                                                     following formats:
 *
 *                                                     * `projects/{project}/locations/{location}`
 *                                                     * `folders/{folder}/locations/{location}`
 *                                                     Please see {@see AuditManagerClient::folderLocationName()} for help formatting this field.
 * @param string $auditScheduleGcsUri                  Cloud Storage bucket where Audit Manager can upload the audit
 *                                                     report and evidence. The format is `gs://{bucket_name}`.
 * @param string $auditScheduleComplianceFramework     Framework (set of controls) that the audit scope report is
 *                                                     generated against. For example, `NIST_800_53`.
 * @param int    $auditScheduleReportFormat            Format for the audit report.
 * @param int    $auditScheduleScheduleConfigFrequency Frequency of audit runs.
 * @param string $auditScheduleId                      ID to use for the audit schedule, which becomes the final
 *                                                     component of the audit schedule's resource name.
 */
function create_audit_schedule_sample(
    string $formattedParent,
    string $auditScheduleGcsUri,
    string $auditScheduleComplianceFramework,
    int $auditScheduleReportFormat,
    int $auditScheduleScheduleConfigFrequency,
    string $auditScheduleId
): void {
    // Create a client.
    $auditManagerClient = new AuditManagerClient();

    // Prepare the request message.
    $auditScheduleScheduleConfigStartTime = new Timestamp();
    $auditScheduleScheduleConfig = (new ScheduleConfig())
        ->setStartTime($auditScheduleScheduleConfigStartTime)
        ->setFrequency($auditScheduleScheduleConfigFrequency);
    $auditSchedule = (new AuditSchedule())
        ->setGcsUri($auditScheduleGcsUri)
        ->setComplianceFramework($auditScheduleComplianceFramework)
        ->setReportFormat($auditScheduleReportFormat)
        ->setScheduleConfig($auditScheduleScheduleConfig);
    $request = (new CreateAuditScheduleRequest())
        ->setParent($formattedParent)
        ->setAuditSchedule($auditSchedule)
        ->setAuditScheduleId($auditScheduleId);

    // Call the API and handle any network failures.
    try {
        /** @var AuditSchedule $response */
        $response = $auditManagerClient->createAuditSchedule($request);
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
    $formattedParent = AuditManagerClient::folderLocationName('[FOLDER]', '[LOCATION]');
    $auditScheduleGcsUri = '[GCS_URI]';
    $auditScheduleComplianceFramework = '[COMPLIANCE_FRAMEWORK]';
    $auditScheduleReportFormat = AuditReportFormat::AUDIT_REPORT_FORMAT_UNSPECIFIED;
    $auditScheduleScheduleConfigFrequency = Frequency::FREQUENCY_UNSPECIFIED;
    $auditScheduleId = '[AUDIT_SCHEDULE_ID]';

    create_audit_schedule_sample(
        $formattedParent,
        $auditScheduleGcsUri,
        $auditScheduleComplianceFramework,
        $auditScheduleReportFormat,
        $auditScheduleScheduleConfigFrequency,
        $auditScheduleId
    );
}
// [END auditmanager_v1_generated_AuditManager_CreateAuditSchedule_sync]
