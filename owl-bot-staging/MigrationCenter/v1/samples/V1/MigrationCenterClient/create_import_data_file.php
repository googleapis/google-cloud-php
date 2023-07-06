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

// [START migrationcenter_v1_generated_MigrationCenter_CreateImportDataFile_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\MigrationCenter\V1\Client\MigrationCenterClient;
use Google\Cloud\MigrationCenter\V1\CreateImportDataFileRequest;
use Google\Cloud\MigrationCenter\V1\ImportDataFile;
use Google\Cloud\MigrationCenter\V1\ImportJobFormat;
use Google\Rpc\Status;

/**
 * Creates an import data file.
 *
 * @param string $formattedParent      Name of the parent of the ImportDataFile. Please see
 *                                     {@see MigrationCenterClient::importJobName()} for help formatting this field.
 * @param string $importDataFileId     The ID of the new data file.
 * @param int    $importDataFileFormat The payload format.
 */
function create_import_data_file_sample(
    string $formattedParent,
    string $importDataFileId,
    int $importDataFileFormat
): void {
    // Create a client.
    $migrationCenterClient = new MigrationCenterClient();

    // Prepare the request message.
    $importDataFile = (new ImportDataFile())
        ->setFormat($importDataFileFormat);
    $request = (new CreateImportDataFileRequest())
        ->setParent($formattedParent)
        ->setImportDataFileId($importDataFileId)
        ->setImportDataFile($importDataFile);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $migrationCenterClient->createImportDataFile($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportDataFile $result */
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
    $formattedParent = MigrationCenterClient::importJobName('[PROJECT]', '[LOCATION]', '[IMPORT_JOB]');
    $importDataFileId = '[IMPORT_DATA_FILE_ID]';
    $importDataFileFormat = ImportJobFormat::IMPORT_JOB_FORMAT_UNSPECIFIED;

    create_import_data_file_sample($formattedParent, $importDataFileId, $importDataFileFormat);
}
// [END migrationcenter_v1_generated_MigrationCenter_CreateImportDataFile_sync]
