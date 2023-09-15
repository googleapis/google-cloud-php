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

// [START notebooks_v2_generated_NotebookService_DiagnoseInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Notebooks\V2\Client\NotebookServiceClient;
use Google\Cloud\Notebooks\V2\DiagnoseInstanceRequest;
use Google\Cloud\Notebooks\V2\DiagnosticConfig;
use Google\Cloud\Notebooks\V2\Instance;
use Google\Rpc\Status;

/**
 * Creates a Diagnostic File and runs Diagnostic Tool given an Instance.
 *
 * @param string $formattedName             Format:
 *                                          `projects/{project_id}/locations/{location}/instances/{instance_id}`
 *                                          Please see {@see NotebookServiceClient::instanceName()} for help formatting this field.
 * @param string $diagnosticConfigGcsBucket User Cloud Storage bucket location (REQUIRED).
 *                                          Must be formatted with path prefix (`gs://$GCS_BUCKET`).
 *
 *                                          Permissions:
 *                                          User Managed Notebooks:
 *                                          - storage.buckets.writer: Must be given to the project's service account
 *                                          attached to VM.
 *                                          Google Managed Notebooks:
 *                                          - storage.buckets.writer: Must be given to the project's service account or
 *                                          user credentials attached to VM depending on authentication mode.
 *
 *                                          Cloud Storage bucket Log file will be written to
 *                                          `gs://$GCS_BUCKET/$RELATIVE_PATH/$VM_DATE_$TIME.tar.gz`
 */
function diagnose_instance_sample(string $formattedName, string $diagnosticConfigGcsBucket): void
{
    // Create a client.
    $notebookServiceClient = new NotebookServiceClient();

    // Prepare the request message.
    $diagnosticConfig = (new DiagnosticConfig())
        ->setGcsBucket($diagnosticConfigGcsBucket);
    $request = (new DiagnoseInstanceRequest())
        ->setName($formattedName)
        ->setDiagnosticConfig($diagnosticConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $notebookServiceClient->diagnoseInstance($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Instance $result */
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
    $formattedName = NotebookServiceClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
    $diagnosticConfigGcsBucket = '[GCS_BUCKET]';

    diagnose_instance_sample($formattedName, $diagnosticConfigGcsBucket);
}
// [END notebooks_v2_generated_NotebookService_DiagnoseInstance_sync]
