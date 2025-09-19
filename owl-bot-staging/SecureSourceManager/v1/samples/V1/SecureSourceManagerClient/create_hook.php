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

// [START securesourcemanager_v1_generated_SecureSourceManager_CreateHook_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\SecureSourceManager\V1\Client\SecureSourceManagerClient;
use Google\Cloud\SecureSourceManager\V1\CreateHookRequest;
use Google\Cloud\SecureSourceManager\V1\Hook;
use Google\Rpc\Status;

/**
 * Creates a new hook in a given repository.
 *
 * @param string $formattedParent The repository in which to create the hook. Values are of the
 *                                form
 *                                `projects/{project_number}/locations/{location_id}/repositories/{repository_id}`
 *                                Please see {@see SecureSourceManagerClient::repositoryName()} for help formatting this field.
 * @param string $hookTargetUri   The target URI to which the payloads will be delivered.
 * @param string $hookId          The ID to use for the hook, which will become the final component
 *                                of the hook's resource name. This value restricts to lower-case letters,
 *                                numbers, and hyphen, with the first character a letter, the last a letter
 *                                or a number, and a 63 character maximum.
 */
function create_hook_sample(string $formattedParent, string $hookTargetUri, string $hookId): void
{
    // Create a client.
    $secureSourceManagerClient = new SecureSourceManagerClient();

    // Prepare the request message.
    $hook = (new Hook())
        ->setTargetUri($hookTargetUri);
    $request = (new CreateHookRequest())
        ->setParent($formattedParent)
        ->setHook($hook)
        ->setHookId($hookId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $secureSourceManagerClient->createHook($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Hook $result */
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
    $formattedParent = SecureSourceManagerClient::repositoryName(
        '[PROJECT]',
        '[LOCATION]',
        '[REPOSITORY]'
    );
    $hookTargetUri = '[TARGET_URI]';
    $hookId = '[HOOK_ID]';

    create_hook_sample($formattedParent, $hookTargetUri, $hookId);
}
// [END securesourcemanager_v1_generated_SecureSourceManager_CreateHook_sync]
