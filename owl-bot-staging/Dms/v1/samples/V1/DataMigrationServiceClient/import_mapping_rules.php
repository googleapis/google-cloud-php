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

// [START datamigration_v1_generated_DataMigrationService_ImportMappingRules_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\CloudDms\V1\ConversionWorkspace;
use Google\Cloud\CloudDms\V1\DataMigrationServiceClient;
use Google\Cloud\CloudDms\V1\ImportMappingRulesRequest\RulesFile;
use Google\Cloud\CloudDms\V1\ImportRulesFileFormat;
use Google\Rpc\Status;

/**
 * Imports the mapping rules for a given conversion workspace.
 * Supports various formats of external rules files.
 *
 * @param string $formattedParent               Name of the conversion workspace resource to import the rules to
 *                                              in the form of:
 *                                              projects/{project}/locations/{location}/conversionWorkspaces/{conversion_workspace}. Please see
 *                                              {@see DataMigrationServiceClient::conversionWorkspaceName()} for help formatting this field.
 * @param int    $rulesFormat                   The format of the rules content file.
 * @param string $rulesFilesRulesSourceFilename The filename of the rules that needs to be converted. The
 *                                              filename is used mainly so that future logs of the import rules job
 *                                              contain it, and can therefore be searched by it.
 * @param string $rulesFilesRulesContent        The text content of the rules that needs to be converted.
 * @param bool   $autoCommit                    Should the conversion workspace be committed automatically after
 *                                              the import operation.
 */
function import_mapping_rules_sample(
    string $formattedParent,
    int $rulesFormat,
    string $rulesFilesRulesSourceFilename,
    string $rulesFilesRulesContent,
    bool $autoCommit
): void {
    // Create a client.
    $dataMigrationServiceClient = new DataMigrationServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $rulesFile = (new RulesFile())
        ->setRulesSourceFilename($rulesFilesRulesSourceFilename)
        ->setRulesContent($rulesFilesRulesContent);
    $rulesFiles = [$rulesFile,];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataMigrationServiceClient->importMappingRules(
            $formattedParent,
            $rulesFormat,
            $rulesFiles,
            $autoCommit
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ConversionWorkspace $result */
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
    $formattedParent = DataMigrationServiceClient::conversionWorkspaceName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONVERSION_WORKSPACE]'
    );
    $rulesFormat = ImportRulesFileFormat::IMPORT_RULES_FILE_FORMAT_UNSPECIFIED;
    $rulesFilesRulesSourceFilename = '[RULES_SOURCE_FILENAME]';
    $rulesFilesRulesContent = '[RULES_CONTENT]';
    $autoCommit = false;

    import_mapping_rules_sample(
        $formattedParent,
        $rulesFormat,
        $rulesFilesRulesSourceFilename,
        $rulesFilesRulesContent,
        $autoCommit
    );
}
// [END datamigration_v1_generated_DataMigrationService_ImportMappingRules_sync]
