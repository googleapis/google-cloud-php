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

// [START dataplex_v1_generated_DataplexService_UpdateTask_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataplex\V1\Client\DataplexServiceClient;
use Google\Cloud\Dataplex\V1\Task;
use Google\Cloud\Dataplex\V1\Task\ExecutionSpec;
use Google\Cloud\Dataplex\V1\Task\TriggerSpec;
use Google\Cloud\Dataplex\V1\Task\TriggerSpec\Type;
use Google\Cloud\Dataplex\V1\UpdateTaskRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Update the task resource.
 *
 * @param int    $taskTriggerSpecType             Immutable. Trigger type of the user-specified Task.
 * @param string $taskExecutionSpecServiceAccount Service account to use to execute a task.
 *                                                If not provided, the default Compute service account for the project is
 *                                                used.
 */
function update_task_sample(
    int $taskTriggerSpecType,
    string $taskExecutionSpecServiceAccount
): void {
    // Create a client.
    $dataplexServiceClient = new DataplexServiceClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $taskTriggerSpec = (new TriggerSpec())
        ->setType($taskTriggerSpecType);
    $taskExecutionSpec = (new ExecutionSpec())
        ->setServiceAccount($taskExecutionSpecServiceAccount);
    $task = (new Task())
        ->setTriggerSpec($taskTriggerSpec)
        ->setExecutionSpec($taskExecutionSpec);
    $request = (new UpdateTaskRequest())
        ->setUpdateMask($updateMask)
        ->setTask($task);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataplexServiceClient->updateTask($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Task $result */
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
    $taskTriggerSpecType = Type::TYPE_UNSPECIFIED;
    $taskExecutionSpecServiceAccount = '[SERVICE_ACCOUNT]';

    update_task_sample($taskTriggerSpecType, $taskExecutionSpecServiceAccount);
}
// [END dataplex_v1_generated_DataplexService_UpdateTask_sync]
