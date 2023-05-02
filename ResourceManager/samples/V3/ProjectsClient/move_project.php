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

// [START cloudresourcemanager_v3_generated_Projects_MoveProject_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ResourceManager\V3\Project;
use Google\Cloud\ResourceManager\V3\ProjectsClient;
use Google\Rpc\Status;

/**
 * Move a project to another place in your resource hierarchy, under a new
 * resource parent.
 *
 * Returns an operation which can be used to track the process of the project
 * move workflow.
 * Upon success, the `Operation.response` field will be populated with the
 * moved project.
 *
 * The caller must have `resourcemanager.projects.move` permission on the
 * project, on the project's current and proposed new parent.
 *
 * If project has no current parent, or it currently does not have an
 * associated organization resource, you will also need the
 * `resourcemanager.projects.setIamPolicy` permission in the project.
 *
 *
 *
 * @param string $formattedName     The name of the project to move. Please see
 *                                  {@see ProjectsClient::projectName()} for help formatting this field.
 * @param string $destinationParent The new parent to move the Project under.
 */
function move_project_sample(string $formattedName, string $destinationParent): void
{
    // Create a client.
    $projectsClient = new ProjectsClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $projectsClient->moveProject($formattedName, $destinationParent);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Project $result */
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
    $formattedName = ProjectsClient::projectName('[PROJECT]');
    $destinationParent = '[DESTINATION_PARENT]';

    move_project_sample($formattedName, $destinationParent);
}
// [END cloudresourcemanager_v3_generated_Projects_MoveProject_sync]
