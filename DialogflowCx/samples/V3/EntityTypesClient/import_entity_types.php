<?php
/*
 * Copyright 2024 Google LLC
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

// [START dialogflow_v3_generated_EntityTypes_ImportEntityTypes_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\Cx\V3\Client\EntityTypesClient;
use Google\Cloud\Dialogflow\Cx\V3\ImportEntityTypesRequest;
use Google\Cloud\Dialogflow\Cx\V3\ImportEntityTypesRequest\MergeOption;
use Google\Cloud\Dialogflow\Cx\V3\ImportEntityTypesResponse;
use Google\Rpc\Status;

/**
 * Imports the specified entitytypes into the agent.
 *
 * @param string $formattedParent The agent to import the entity types into.
 *                                Format: `projects/<Project ID>/locations/<Location ID>/agents/<Agent ID>`. Please see
 *                                {@see EntityTypesClient::agentName()} for help formatting this field.
 * @param int    $mergeOption     Merge option for importing entity types.
 */
function import_entity_types_sample(string $formattedParent, int $mergeOption): void
{
    // Create a client.
    $entityTypesClient = new EntityTypesClient();

    // Prepare the request message.
    $request = (new ImportEntityTypesRequest())
        ->setParent($formattedParent)
        ->setMergeOption($mergeOption);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $entityTypesClient->importEntityTypes($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportEntityTypesResponse $result */
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
    $formattedParent = EntityTypesClient::agentName('[PROJECT]', '[LOCATION]', '[AGENT]');
    $mergeOption = MergeOption::MERGE_OPTION_UNSPECIFIED;

    import_entity_types_sample($formattedParent, $mergeOption);
}
// [END dialogflow_v3_generated_EntityTypes_ImportEntityTypes_sync]
