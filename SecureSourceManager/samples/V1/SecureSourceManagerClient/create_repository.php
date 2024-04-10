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

// [START securesourcemanager_v1_generated_SecureSourceManager_CreateRepository_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\SecureSourceManager\V1\Client\SecureSourceManagerClient;
use Google\Cloud\SecureSourceManager\V1\CreateRepositoryRequest;
use Google\Cloud\SecureSourceManager\V1\Repository;
use Google\Rpc\Status;

/**
 * Creates a new repository in a given project and location.
 *
 * **Host: Data Plane**
 *
 * @param string $formattedParent The project in which to create the repository. Values are of the
 *                                form `projects/{project_number}/locations/{location_id}`
 *                                Please see {@see SecureSourceManagerClient::locationName()} for help formatting this field.
 * @param string $repositoryId    The ID to use for the repository, which will become the final
 *                                component of the repository's resource name. This value should be 4-63
 *                                characters, and valid characters are /[a-z][0-9]-/.
 */
function create_repository_sample(string $formattedParent, string $repositoryId): void
{
    // Create a client.
    $secureSourceManagerClient = new SecureSourceManagerClient();

    // Prepare the request message.
    $repository = new Repository();
    $request = (new CreateRepositoryRequest())
        ->setParent($formattedParent)
        ->setRepository($repository)
        ->setRepositoryId($repositoryId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $secureSourceManagerClient->createRepository($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Repository $result */
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
    $formattedParent = SecureSourceManagerClient::locationName('[PROJECT]', '[LOCATION]');
    $repositoryId = '[REPOSITORY_ID]';

    create_repository_sample($formattedParent, $repositoryId);
}
// [END securesourcemanager_v1_generated_SecureSourceManager_CreateRepository_sync]
