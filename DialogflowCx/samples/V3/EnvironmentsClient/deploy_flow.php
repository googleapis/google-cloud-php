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

// [START dialogflow_v3_generated_Environments_DeployFlow_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\Cx\V3\Client\EnvironmentsClient;
use Google\Cloud\Dialogflow\Cx\V3\DeployFlowRequest;
use Google\Cloud\Dialogflow\Cx\V3\DeployFlowResponse;
use Google\Rpc\Status;

/**
 * Deploys a flow to the specified
 * [Environment][google.cloud.dialogflow.cx.v3.Environment].
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`:
 * [DeployFlowMetadata][google.cloud.dialogflow.cx.v3.DeployFlowMetadata]
 * - `response`:
 * [DeployFlowResponse][google.cloud.dialogflow.cx.v3.DeployFlowResponse]
 *
 * @param string $formattedEnvironment The environment to deploy the flow to.
 *                                     Format: `projects/<Project ID>/locations/<Location ID>/agents/<Agent ID>/
 *                                     environments/<Environment ID>`. Please see
 *                                     {@see EnvironmentsClient::environmentName()} for help formatting this field.
 * @param string $formattedFlowVersion The flow version to deploy.
 *                                     Format: `projects/<Project ID>/locations/<Location ID>/agents/<Agent ID>/
 *                                     flows/<Flow ID>/versions/<Version ID>`. Please see
 *                                     {@see EnvironmentsClient::versionName()} for help formatting this field.
 */
function deploy_flow_sample(string $formattedEnvironment, string $formattedFlowVersion): void
{
    // Create a client.
    $environmentsClient = new EnvironmentsClient();

    // Prepare the request message.
    $request = (new DeployFlowRequest())
        ->setEnvironment($formattedEnvironment)
        ->setFlowVersion($formattedFlowVersion);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $environmentsClient->deployFlow($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DeployFlowResponse $result */
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
    $formattedEnvironment = EnvironmentsClient::environmentName(
        '[PROJECT]',
        '[LOCATION]',
        '[AGENT]',
        '[ENVIRONMENT]'
    );
    $formattedFlowVersion = EnvironmentsClient::versionName(
        '[PROJECT]',
        '[LOCATION]',
        '[AGENT]',
        '[FLOW]',
        '[VERSION]'
    );

    deploy_flow_sample($formattedEnvironment, $formattedFlowVersion);
}
// [END dialogflow_v3_generated_Environments_DeployFlow_sync]
