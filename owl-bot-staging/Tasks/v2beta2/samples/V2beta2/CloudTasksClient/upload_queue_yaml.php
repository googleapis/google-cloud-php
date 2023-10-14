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

// [START cloudtasks_v2beta2_generated_CloudTasks_UploadQueueYaml_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Tasks\V2beta2\CloudTasksClient;

/**
 * Update queue list by uploading a queue.yaml file.
 *
 * The queue.yaml file is supplied in the request body as a YAML encoded
 * string. This method was added to support gcloud clients versions before
 * 322.0.0. New clients should use CreateQueue instead of this method.
 *
 * @param string $appId The App ID is supplied as an HTTP parameter. Unlike internal
 *                      usage of App ID, it does not include a region prefix. Rather, the App ID
 *                      represents the Project ID against which to make the request.
 */
function upload_queue_yaml_sample(string $appId): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Call the API and handle any network failures.
    try {
        $cloudTasksClient->uploadQueueYaml($appId);
        printf('Call completed successfully.' . PHP_EOL);
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
    $appId = '[APP_ID]';

    upload_queue_yaml_sample($appId);
}
// [END cloudtasks_v2beta2_generated_CloudTasks_UploadQueueYaml_sync]
