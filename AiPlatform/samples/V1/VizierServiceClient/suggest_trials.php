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

// [START aiplatform_v1_generated_VizierService_SuggestTrials_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\SuggestTrialsResponse;
use Google\Cloud\AIPlatform\V1\VizierServiceClient;
use Google\Rpc\Status;

/**
 * Adds one or more Trials to a Study, with parameter values
 * suggested by Vertex AI Vizier. Returns a long-running
 * operation associated with the generation of Trial suggestions.
 * When this long-running operation succeeds, it will contain
 * a [SuggestTrialsResponse][google.cloud.ml.v1.SuggestTrialsResponse].
 *
 * @param string $formattedParent The project and location that the Study belongs to.
 *                                Format: `projects/{project}/locations/{location}/studies/{study}`
 *                                Please see {@see VizierServiceClient::studyName()} for help formatting this field.
 * @param int    $suggestionCount The number of suggestions requested. It must be positive.
 * @param string $clientId        The identifier of the client that is requesting the suggestion.
 *
 *                                If multiple SuggestTrialsRequests have the same `client_id`,
 *                                the service will return the identical suggested Trial if the Trial is
 *                                pending, and provide a new Trial if the last suggested Trial was completed.
 */
function suggest_trials_sample(
    string $formattedParent,
    int $suggestionCount,
    string $clientId
): void {
    // Create a client.
    $vizierServiceClient = new VizierServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vizierServiceClient->suggestTrials($formattedParent, $suggestionCount, $clientId);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var SuggestTrialsResponse $result */
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
    $formattedParent = VizierServiceClient::studyName('[PROJECT]', '[LOCATION]', '[STUDY]');
    $suggestionCount = 0;
    $clientId = '[CLIENT_ID]';

    suggest_trials_sample($formattedParent, $suggestionCount, $clientId);
}
// [END aiplatform_v1_generated_VizierService_SuggestTrials_sync]
