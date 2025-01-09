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

// [START backupdr_v1_generated_BackupDR_InitializeService_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BackupDR\V1\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1\InitializeServiceRequest;
use Google\Cloud\BackupDR\V1\InitializeServiceResponse;
use Google\Rpc\Status;

/**
 * Initializes the service related config for a project.
 *
 * @param string $name         The resource name of the serviceConfig used to initialize the
 *                             service. Format:
 *                             `projects/{project_id}/locations/{location}/serviceConfig`.
 * @param string $resourceType The resource type to which the default service config will be
 *                             applied. Examples include, "compute.googleapis.com/Instance" and
 *                             "storage.googleapis.com/Bucket".
 */
function initialize_service_sample(string $name, string $resourceType): void
{
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $request = (new InitializeServiceRequest())
        ->setName($name)
        ->setResourceType($resourceType);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupDRClient->initializeService($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var InitializeServiceResponse $result */
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
    $name = '[NAME]';
    $resourceType = '[RESOURCE_TYPE]';

    initialize_service_sample($name, $resourceType);
}
// [END backupdr_v1_generated_BackupDR_InitializeService_sync]
