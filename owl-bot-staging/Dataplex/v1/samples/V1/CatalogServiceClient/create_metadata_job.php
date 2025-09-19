<?php
/*
 * Copyright 2025 Google LLC
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

// [START dataplex_v1_generated_CatalogService_CreateMetadataJob_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataplex\V1\Client\CatalogServiceClient;
use Google\Cloud\Dataplex\V1\CreateMetadataJobRequest;
use Google\Cloud\Dataplex\V1\MetadataJob;
use Google\Cloud\Dataplex\V1\MetadataJob\Type;
use Google\Rpc\Status;

/**
 * Creates a metadata job. For example, use a metadata job to import metadata
 * from a third-party system into Dataplex Universal Catalog.
 *
 * @param string $formattedParent The resource name of the parent location, in the format
 *                                `projects/{project_id_or_number}/locations/{location_id}`
 *                                Please see {@see CatalogServiceClient::locationName()} for help formatting this field.
 * @param int    $metadataJobType Metadata job type.
 */
function create_metadata_job_sample(string $formattedParent, int $metadataJobType): void
{
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare the request message.
    $metadataJob = (new MetadataJob())
        ->setType($metadataJobType);
    $request = (new CreateMetadataJobRequest())
        ->setParent($formattedParent)
        ->setMetadataJob($metadataJob);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $catalogServiceClient->createMetadataJob($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var MetadataJob $result */
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
    $formattedParent = CatalogServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $metadataJobType = Type::TYPE_UNSPECIFIED;

    create_metadata_job_sample($formattedParent, $metadataJobType);
}
// [END dataplex_v1_generated_CatalogService_CreateMetadataJob_sync]
