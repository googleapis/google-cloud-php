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

// [START backupdr_v1_generated_BackupDR_CreateRestoreTemplate_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BackupDR\V1\BackupSelectionConfig;
use Google\Cloud\BackupDR\V1\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1\CreateRestoreTemplateRequest;
use Google\Cloud\BackupDR\V1\RestoreTemplate;
use Google\Protobuf\Struct;
use Google\Rpc\Status;

/**
 * Creates a new RestoreTemplate in a given project and location.
 *
 * @param string $formattedParent                                         The restore template project and location in the format
 *                                                                        'projects/{project_id}/locations/{location}'. Please see
 *                                                                        {@see BackupDRClient::locationName()} for help formatting this field.
 * @param string $restoreTemplateId                                       The ID of the restore template to create. The ID must be
 *                                                                        unique for the specified project and location.
 * @param string $restoreTemplateResourceType                             Immutable. The specific type of the workload being restored.
 *                                                                        The format is "{service_name}/{resource_kind}", for example,
 *                                                                        "compute.googleapis.com/Instance".
 * @param string $formattedRestoreTemplateBackupSelectionConfigDataSource Immutable. The fully qualified URI of the backupdr data source. Please see
 *                                                                        {@see BackupDRClient::dataSourceName()} for help formatting this field.
 */
function create_restore_template_sample(
    string $formattedParent,
    string $restoreTemplateId,
    string $restoreTemplateResourceType,
    string $formattedRestoreTemplateBackupSelectionConfigDataSource
): void {
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $restoreTemplateBackupSelectionConfig = (new BackupSelectionConfig())
        ->setDataSource($formattedRestoreTemplateBackupSelectionConfigDataSource);
    $restoreTemplateRestoreProperties = new Struct();
    $restoreTemplate = (new RestoreTemplate())
        ->setResourceType($restoreTemplateResourceType)
        ->setBackupSelectionConfig($restoreTemplateBackupSelectionConfig)
        ->setRestoreProperties($restoreTemplateRestoreProperties);
    $request = (new CreateRestoreTemplateRequest())
        ->setParent($formattedParent)
        ->setRestoreTemplateId($restoreTemplateId)
        ->setRestoreTemplate($restoreTemplate);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupDRClient->createRestoreTemplate($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RestoreTemplate $result */
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
    $formattedParent = BackupDRClient::locationName('[PROJECT]', '[LOCATION]');
    $restoreTemplateId = '[RESTORE_TEMPLATE_ID]';
    $restoreTemplateResourceType = '[RESOURCE_TYPE]';
    $formattedRestoreTemplateBackupSelectionConfigDataSource = BackupDRClient::dataSourceName(
        '[PROJECT]',
        '[LOCATION]',
        '[BACKUPVAULT]',
        '[DATASOURCE]'
    );

    create_restore_template_sample(
        $formattedParent,
        $restoreTemplateId,
        $restoreTemplateResourceType,
        $formattedRestoreTemplateBackupSelectionConfigDataSource
    );
}
// [END backupdr_v1_generated_BackupDR_CreateRestoreTemplate_sync]
