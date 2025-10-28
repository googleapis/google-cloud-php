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

// [START cloudsecuritycompliance_v1_generated_Audit_CreateFrameworkAudit_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\CloudSecurityCompliance\V1\Client\AuditClient;
use Google\Cloud\CloudSecurityCompliance\V1\CreateFrameworkAuditRequest;
use Google\Cloud\CloudSecurityCompliance\V1\FrameworkAudit;
use Google\Cloud\CloudSecurityCompliance\V1\FrameworkAuditDestination;
use Google\Rpc\Status;

/**
 * Creates an audit scope report for a framework.
 *
 * @param string $formattedParent The parent resource where this framework audit is created.
 *
 *                                Supported formats are the following:
 *
 *                                * `organizations/{organization_id}/locations/{location}`
 *                                * `folders/{folder_id}/locations/{location}`
 *                                * `projects/{project_id}/locations/{location}`
 *                                Please see {@see AuditClient::organizationLocationName()} for help formatting this field.
 */
function create_framework_audit_sample(string $formattedParent): void
{
    // Create a client.
    $auditClient = new AuditClient();

    // Prepare the request message.
    $frameworkAuditFrameworkAuditDestination = new FrameworkAuditDestination();
    $frameworkAudit = (new FrameworkAudit())
        ->setFrameworkAuditDestination($frameworkAuditFrameworkAuditDestination);
    $request = (new CreateFrameworkAuditRequest())
        ->setParent($formattedParent)
        ->setFrameworkAudit($frameworkAudit);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $auditClient->createFrameworkAudit($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var FrameworkAudit $result */
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
    $formattedParent = AuditClient::organizationLocationName('[ORGANIZATION]', '[LOCATION]');

    create_framework_audit_sample($formattedParent);
}
// [END cloudsecuritycompliance_v1_generated_Audit_CreateFrameworkAudit_sync]
