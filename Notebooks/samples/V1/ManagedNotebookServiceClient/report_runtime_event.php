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

// [START notebooks_v1_generated_ManagedNotebookService_ReportRuntimeEvent_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Notebooks\V1\Client\ManagedNotebookServiceClient;
use Google\Cloud\Notebooks\V1\Event;
use Google\Cloud\Notebooks\V1\ReportRuntimeEventRequest;
use Google\Cloud\Notebooks\V1\Runtime;
use Google\Rpc\Status;

/**
 * Report and process a runtime event.
 *
 * @param string $formattedName Format:
 *                              `projects/{project_id}/locations/{location}/runtimes/{runtime_id}`
 *                              Please see {@see ManagedNotebookServiceClient::runtimeName()} for help formatting this field.
 * @param string $vmId          The VM hardware token for authenticating the VM.
 *                              https://cloud.google.com/compute/docs/instances/verifying-instance-identity
 */
function report_runtime_event_sample(string $formattedName, string $vmId): void
{
    // Create a client.
    $managedNotebookServiceClient = new ManagedNotebookServiceClient();

    // Prepare the request message.
    $event = new Event();
    $request = (new ReportRuntimeEventRequest())
        ->setName($formattedName)
        ->setVmId($vmId)
        ->setEvent($event);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $managedNotebookServiceClient->reportRuntimeEvent($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Runtime $result */
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
    $formattedName = ManagedNotebookServiceClient::runtimeName('[PROJECT]', '[LOCATION]', '[RUNTIME]');
    $vmId = '[VM_ID]';

    report_runtime_event_sample($formattedName, $vmId);
}
// [END notebooks_v1_generated_ManagedNotebookService_ReportRuntimeEvent_sync]
