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

// [START dataplex_v1_generated_DataplexService_CreateLake_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataplex\V1\Client\DataplexServiceClient;
use Google\Cloud\Dataplex\V1\CreateLakeRequest;
use Google\Cloud\Dataplex\V1\Lake;
use Google\Rpc\Status;

/**
 * Creates a lake resource.
 *
 * @param string $formattedParent The resource name of the lake location, of the form:
 *                                projects/{project_number}/locations/{location_id}
 *                                where `location_id` refers to a GCP region. Please see
 *                                {@see DataplexServiceClient::locationName()} for help formatting this field.
 * @param string $lakeId          Lake identifier.
 *                                This ID will be used to generate names such as database and dataset names
 *                                when publishing metadata to Hive Metastore and BigQuery.
 *                                * Must contain only lowercase letters, numbers and hyphens.
 *                                * Must start with a letter.
 *                                * Must end with a number or a letter.
 *                                * Must be between 1-63 characters.
 *                                * Must be unique within the customer project / location.
 */
function create_lake_sample(string $formattedParent, string $lakeId): void
{
    // Create a client.
    $dataplexServiceClient = new DataplexServiceClient();

    // Prepare the request message.
    $lake = new Lake();
    $request = (new CreateLakeRequest())
        ->setParent($formattedParent)
        ->setLakeId($lakeId)
        ->setLake($lake);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataplexServiceClient->createLake($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Lake $result */
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
    $formattedParent = DataplexServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $lakeId = '[LAKE_ID]';

    create_lake_sample($formattedParent, $lakeId);
}
// [END dataplex_v1_generated_DataplexService_CreateLake_sync]
