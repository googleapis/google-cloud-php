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

// [START cloudsecuritycompliance_v1_generated_Audit_ListFrameworkAudits_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\CloudSecurityCompliance\V1\Client\AuditClient;
use Google\Cloud\CloudSecurityCompliance\V1\FrameworkAudit;
use Google\Cloud\CloudSecurityCompliance\V1\ListFrameworkAuditsRequest;

/**
 * Lists the framework audits for a given organization, folder, or project.
 *
 * @param string $formattedParent The parent resource where the framework audits are listed.
 *
 *                                Supported formats are the following:
 *
 *                                * `organizations/{organization_id}/locations/{location}`
 *                                * `folders/{folder_id}/locations/{location}`
 *                                * `projects/{project_id}/locations/{location}`
 *                                Please see {@see AuditClient::organizationLocationName()} for help formatting this field.
 */
function list_framework_audits_sample(string $formattedParent): void
{
    // Create a client.
    $auditClient = new AuditClient();

    // Prepare the request message.
    $request = (new ListFrameworkAuditsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $auditClient->listFrameworkAudits($request);

        /** @var FrameworkAudit $element */
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
    $formattedParent = AuditClient::organizationLocationName('[ORGANIZATION]', '[LOCATION]');

    list_framework_audits_sample($formattedParent);
}
// [END cloudsecuritycompliance_v1_generated_Audit_ListFrameworkAudits_sync]
