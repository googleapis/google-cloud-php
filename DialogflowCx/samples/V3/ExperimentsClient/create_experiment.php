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

// [START dialogflow_v3_generated_Experiments_CreateExperiment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Client\ExperimentsClient;
use Google\Cloud\Dialogflow\Cx\V3\CreateExperimentRequest;
use Google\Cloud\Dialogflow\Cx\V3\Experiment;

/**
 * Creates an [Experiment][google.cloud.dialogflow.cx.v3.Experiment] in the
 * specified [Environment][google.cloud.dialogflow.cx.v3.Environment].
 *
 * @param string $formattedParent       The [Agent][google.cloud.dialogflow.cx.v3.Agent] to create an
 *                                      [Environment][google.cloud.dialogflow.cx.v3.Environment] for. Format:
 *                                      `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/environments/<EnvironmentID>`. Please see
 *                                      {@see ExperimentsClient::environmentName()} for help formatting this field.
 * @param string $experimentDisplayName The human-readable name of the experiment (unique in an
 *                                      environment). Limit of 64 characters.
 */
function create_experiment_sample(string $formattedParent, string $experimentDisplayName): void
{
    // Create a client.
    $experimentsClient = new ExperimentsClient();

    // Prepare the request message.
    $experiment = (new Experiment())
        ->setDisplayName($experimentDisplayName);
    $request = (new CreateExperimentRequest())
        ->setParent($formattedParent)
        ->setExperiment($experiment);

    // Call the API and handle any network failures.
    try {
        /** @var Experiment $response */
        $response = $experimentsClient->createExperiment($request);
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
    $formattedParent = ExperimentsClient::environmentName(
        '[PROJECT]',
        '[LOCATION]',
        '[AGENT]',
        '[ENVIRONMENT]'
    );
    $experimentDisplayName = '[DISPLAY_NAME]';

    create_experiment_sample($formattedParent, $experimentDisplayName);
}
// [END dialogflow_v3_generated_Experiments_CreateExperiment_sync]
