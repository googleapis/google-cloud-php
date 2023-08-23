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

// [START dialogflow_v2_generated_Environments_UpdateEnvironment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Environment;
use Google\Cloud\Dialogflow\V2\EnvironmentsClient;
use Google\Protobuf\FieldMask;

/**
 * Updates the specified agent environment.
 *
 * This method allows you to deploy new agent versions into the environment.
 * When an environment is pointed to a new agent version by setting
 * `environment.agent_version`, the environment is temporarily set to the
 * `LOADING` state. During that time, the environment continues serving the
 * previous version of the agent. After the new agent version is done loading,
 * the environment is set back to the `RUNNING` state.
 * You can use "-" as Environment ID in environment name to update an agent
 * version in the default environment. WARNING: this will negate all recent
 * changes to the draft agent and can't be undone. You may want to save the
 * draft agent to a version before calling this method.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_environment_sample(): void
{
    // Create a client.
    $environmentsClient = new EnvironmentsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $environment = new Environment();
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var Environment $response */
        $response = $environmentsClient->updateEnvironment($environment, $updateMask);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END dialogflow_v2_generated_Environments_UpdateEnvironment_sync]
