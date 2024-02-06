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

// [START dataplex_v1_generated_DataTaxonomyService_CreateDataTaxonomy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataplex\V1\Client\DataTaxonomyServiceClient;
use Google\Cloud\Dataplex\V1\CreateDataTaxonomyRequest;
use Google\Cloud\Dataplex\V1\DataTaxonomy;
use Google\Rpc\Status;

/**
 * Create a DataTaxonomy resource.
 *
 * @param string $formattedParent The resource name of the data taxonomy location, of the form:
 *                                projects/{project_number}/locations/{location_id}
 *                                where `location_id` refers to a GCP region. Please see
 *                                {@see DataTaxonomyServiceClient::locationName()} for help formatting this field.
 * @param string $dataTaxonomyId  DataTaxonomy identifier.
 *                                * Must contain only lowercase letters, numbers and hyphens.
 *                                * Must start with a letter.
 *                                * Must be between 1-63 characters.
 *                                * Must end with a number or a letter.
 *                                * Must be unique within the Project.
 */
function create_data_taxonomy_sample(string $formattedParent, string $dataTaxonomyId): void
{
    // Create a client.
    $dataTaxonomyServiceClient = new DataTaxonomyServiceClient();

    // Prepare the request message.
    $dataTaxonomy = new DataTaxonomy();
    $request = (new CreateDataTaxonomyRequest())
        ->setParent($formattedParent)
        ->setDataTaxonomyId($dataTaxonomyId)
        ->setDataTaxonomy($dataTaxonomy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataTaxonomyServiceClient->createDataTaxonomy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DataTaxonomy $result */
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
    $formattedParent = DataTaxonomyServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $dataTaxonomyId = '[DATA_TAXONOMY_ID]';

    create_data_taxonomy_sample($formattedParent, $dataTaxonomyId);
}
// [END dataplex_v1_generated_DataTaxonomyService_CreateDataTaxonomy_sync]
