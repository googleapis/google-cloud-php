<?php
/*
 * Copyright 2022 Google LLC
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

// [START vmmigration_v1_generated_VmMigration_CreateTargetProject_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VMMigration\V1\Client\VmMigrationClient;
use Google\Cloud\VMMigration\V1\CreateTargetProjectRequest;
use Google\Cloud\VMMigration\V1\TargetProject;
use Google\Rpc\Status;

/**
 * Creates a new TargetProject in a given project.
 *
 * NOTE: TargetProject is a global resource; hence the only supported value
 * for location is `global`.
 *
 * @param string $formattedParent The TargetProject's parent. Please see
 *                                {@see VmMigrationClient::locationName()} for help formatting this field.
 * @param string $targetProjectId The target_project identifier.
 */
function create_target_project_sample(string $formattedParent, string $targetProjectId): void
{
    // Create a client.
    $vmMigrationClient = new VmMigrationClient();

    // Prepare the request message.
    $targetProject = new TargetProject();
    $request = (new CreateTargetProjectRequest())
        ->setParent($formattedParent)
        ->setTargetProjectId($targetProjectId)
        ->setTargetProject($targetProject);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmMigrationClient->createTargetProject($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var TargetProject $result */
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
    $formattedParent = VmMigrationClient::locationName('[PROJECT]', '[LOCATION]');
    $targetProjectId = '[TARGET_PROJECT_ID]';

    create_target_project_sample($formattedParent, $targetProjectId);
}
// [END vmmigration_v1_generated_VmMigration_CreateTargetProject_sync]
