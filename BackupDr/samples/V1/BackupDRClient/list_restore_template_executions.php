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

// [START backupdr_v1_generated_BackupDR_ListRestoreTemplateExecutions_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\BackupDR\V1\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1\ListRestoreTemplateExecutionsRequest;
use Google\Cloud\BackupDR\V1\RestoreTemplateExecution;

/**
 * Lists RestoreTemplateExecutions in a given project, location and restore
 * template.
 *
 * @param string $formattedParent The project, location, and restore template for which to retrieve
 *                                executions information.
 *                                Format:
 *                                `projects/{project}/locations/{location}/restoreTemplates/{restore_template}`. Please see
 *                                {@see BackupDRClient::restoreTemplateName()} for help formatting this field.
 */
function list_restore_template_executions_sample(string $formattedParent): void
{
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $request = (new ListRestoreTemplateExecutionsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $backupDRClient->listRestoreTemplateExecutions($request);

        /** @var RestoreTemplateExecution $element */
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
    $formattedParent = BackupDRClient::restoreTemplateName(
        '[PROJECT]',
        '[LOCATION]',
        '[RESTORE_TEMPLATE]'
    );

    list_restore_template_executions_sample($formattedParent);
}
// [END backupdr_v1_generated_BackupDR_ListRestoreTemplateExecutions_sync]
