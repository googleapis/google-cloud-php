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

// [START run_v2_generated_Executions_ListExecutions_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Run\V2\Client\ExecutionsClient;
use Google\Cloud\Run\V2\Execution;
use Google\Cloud\Run\V2\ListExecutionsRequest;

/**
 * Lists Executions from a Job.
 *
 * @param string $formattedParent The Execution from which the Executions should be listed.
 *                                To list all Executions across Jobs, use "-" instead of Job name.
 *                                Format: projects/{project}/locations/{location}/jobs/{job}, where {project}
 *                                can be project id or number. Please see
 *                                {@see ExecutionsClient::jobName()} for help formatting this field.
 */
function list_executions_sample(string $formattedParent): void
{
    // Create a client.
    $executionsClient = new ExecutionsClient();

    // Prepare the request message.
    $request = (new ListExecutionsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $executionsClient->listExecutions($request);

        /** @var Execution $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = ExecutionsClient::jobName('[PROJECT]', '[LOCATION]', '[JOB]');

    list_executions_sample($formattedParent);
}
// [END run_v2_generated_Executions_ListExecutions_sync]
