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

// [START aiplatform_v1_generated_MetadataService_CreateArtifact_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Artifact;
use Google\Cloud\AIPlatform\V1\Client\MetadataServiceClient;
use Google\Cloud\AIPlatform\V1\CreateArtifactRequest;

/**
 * Creates an Artifact associated with a MetadataStore.
 *
 * @param string $formattedParent The resource name of the MetadataStore where the Artifact should
 *                                be created.
 *                                Format:
 *                                `projects/{project}/locations/{location}/metadataStores/{metadatastore}`
 *                                Please see {@see MetadataServiceClient::metadataStoreName()} for help formatting this field.
 */
function create_artifact_sample(string $formattedParent): void
{
    // Create a client.
    $metadataServiceClient = new MetadataServiceClient();

    // Prepare the request message.
    $artifact = new Artifact();
    $request = (new CreateArtifactRequest())
        ->setParent($formattedParent)
        ->setArtifact($artifact);

    // Call the API and handle any network failures.
    try {
        /** @var Artifact $response */
        $response = $metadataServiceClient->createArtifact($request);
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
    $formattedParent = MetadataServiceClient::metadataStoreName(
        '[PROJECT]',
        '[LOCATION]',
        '[METADATA_STORE]'
    );

    create_artifact_sample($formattedParent);
}
// [END aiplatform_v1_generated_MetadataService_CreateArtifact_sync]
