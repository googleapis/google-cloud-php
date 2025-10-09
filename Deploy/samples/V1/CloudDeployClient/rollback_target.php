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

// [START clouddeploy_v1_generated_CloudDeploy_RollbackTarget_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Deploy\V1\Client\CloudDeployClient;
use Google\Cloud\Deploy\V1\RollbackTargetRequest;
use Google\Cloud\Deploy\V1\RollbackTargetResponse;

/**
 * Creates a `Rollout` to roll back the specified target.
 *
 * @param string $formattedName The `DeliveryPipeline` for which the rollback `Rollout` must be
 *                              created. The format is
 *                              `projects/{project_id}/locations/{location_name}/deliveryPipelines/{pipeline_name}`. Please see
 *                              {@see CloudDeployClient::deliveryPipelineName()} for help formatting this field.
 * @param string $targetId      ID of the `Target` that is being rolled back.
 * @param string $rolloutId     ID of the rollback `Rollout` to create.
 */
function rollback_target_sample(string $formattedName, string $targetId, string $rolloutId): void
{
    // Create a client.
    $cloudDeployClient = new CloudDeployClient();

    // Prepare the request message.
    $request = (new RollbackTargetRequest())
        ->setName($formattedName)
        ->setTargetId($targetId)
        ->setRolloutId($rolloutId);

    // Call the API and handle any network failures.
    try {
        /** @var RollbackTargetResponse $response */
        $response = $cloudDeployClient->rollbackTarget($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $formattedName = CloudDeployClient::deliveryPipelineName(
        '[PROJECT]',
        '[LOCATION]',
        '[DELIVERY_PIPELINE]'
    );
    $targetId = '[TARGET_ID]';
    $rolloutId = '[ROLLOUT_ID]';

    rollback_target_sample($formattedName, $targetId, $rolloutId);
}
// [END clouddeploy_v1_generated_CloudDeploy_RollbackTarget_sync]
