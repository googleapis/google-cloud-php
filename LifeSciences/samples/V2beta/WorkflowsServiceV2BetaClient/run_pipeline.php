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

// [START lifesciences_v2beta_generated_WorkflowsServiceV2Beta_RunPipeline_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\LifeSciences\V2beta\Pipeline;
use Google\Cloud\LifeSciences\V2beta\RunPipelineResponse;
use Google\Cloud\LifeSciences\V2beta\WorkflowsServiceV2BetaClient;
use Google\Rpc\Status;

/**
 * Runs a pipeline.  The returned Operation's [metadata]
 * [google.longrunning.Operation.metadata] field will contain a
 * [google.cloud.lifesciences.v2beta.Metadata][google.cloud.lifesciences.v2beta.Metadata] object describing the status
 * of the pipeline execution. The
 * [response][google.longrunning.Operation.response] field will contain a
 * [google.cloud.lifesciences.v2beta.RunPipelineResponse][google.cloud.lifesciences.v2beta.RunPipelineResponse] object if the
 * pipeline completes successfully.
 *
 * **Note:** Before you can use this method, the *Life Sciences Service Agent*
 * must have access to your project. This is done automatically when the
 * Cloud Life Sciences API is first enabled, but if you delete this permission
 * you must disable and re-enable the API to grant the Life Sciences
 * Service Agent the required permissions.
 * Authorization requires the following [Google
 * IAM](https://cloud.google.com/iam/) permission:
 *
 * * `lifesciences.workflows.run`
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function run_pipeline_sample(): void
{
    // Create a client.
    $workflowsServiceV2BetaClient = new WorkflowsServiceV2BetaClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $pipeline = new Pipeline();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $workflowsServiceV2BetaClient->runPipeline($pipeline);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RunPipelineResponse $result */
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
// [END lifesciences_v2beta_generated_WorkflowsServiceV2Beta_RunPipeline_sync]
