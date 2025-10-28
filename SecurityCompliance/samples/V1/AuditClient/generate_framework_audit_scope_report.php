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

// [START cloudsecuritycompliance_v1_generated_Audit_GenerateFrameworkAuditScopeReport_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudSecurityCompliance\V1\Client\AuditClient;
use Google\Cloud\CloudSecurityCompliance\V1\GenerateFrameworkAuditScopeReportRequest;
use Google\Cloud\CloudSecurityCompliance\V1\GenerateFrameworkAuditScopeReportRequest\Format;
use Google\Cloud\CloudSecurityCompliance\V1\GenerateFrameworkAuditScopeReportResponse;

/**
 * Generates an audit scope report for a framework.
 *
 * @param string $scope               The organization, folder or project for the audit report.
 *
 *                                    Supported formats are the following:
 *
 *                                    * `projects/{project_id}/locations/{location}`
 *                                    * `folders/{folder_id}/locations/{location}`
 *                                    * `organizations/{organization_id}/locations/{location}`
 * @param int    $reportFormat        The format that the scope report bytes is returned in.
 * @param string $complianceFramework The compliance framework that the scope report is generated for.
 */
function generate_framework_audit_scope_report_sample(
    string $scope,
    int $reportFormat,
    string $complianceFramework
): void {
    // Create a client.
    $auditClient = new AuditClient();

    // Prepare the request message.
    $request = (new GenerateFrameworkAuditScopeReportRequest())
        ->setScope($scope)
        ->setReportFormat($reportFormat)
        ->setComplianceFramework($complianceFramework);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateFrameworkAuditScopeReportResponse $response */
        $response = $auditClient->generateFrameworkAuditScopeReport($request);
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
    $scope = '[SCOPE]';
    $reportFormat = Format::FORMAT_UNSPECIFIED;
    $complianceFramework = '[COMPLIANCE_FRAMEWORK]';

    generate_framework_audit_scope_report_sample($scope, $reportFormat, $complianceFramework);
}
// [END cloudsecuritycompliance_v1_generated_Audit_GenerateFrameworkAuditScopeReport_sync]
