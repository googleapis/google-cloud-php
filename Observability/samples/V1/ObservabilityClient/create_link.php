<?php
/*
 * Copyright 2026 Google LLC
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

// [START observability_v1_generated_Observability_CreateLink_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Observability\V1\Client\ObservabilityClient;
use Google\Cloud\Observability\V1\CreateLinkRequest;
use Google\Cloud\Observability\V1\Link;
use Google\Rpc\Status;

/**
 * Create a new link.
 *
 * @param string $formattedParent Name of the containing dataset for this link. The format is:
 *
 *                                projects/[PROJECT_ID]/locations/[LOCATION]/buckets/[BUCKET_ID]/datasets/[DATASET_ID]
 *                                Please see {@see ObservabilityClient::datasetName()} for help formatting this field.
 * @param string $linkId          Id of the link to create.
 */
function create_link_sample(string $formattedParent, string $linkId): void
{
    // Create a client.
    $observabilityClient = new ObservabilityClient();

    // Prepare the request message.
    $link = new Link();
    $request = (new CreateLinkRequest())
        ->setParent($formattedParent)
        ->setLinkId($linkId)
        ->setLink($link);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $observabilityClient->createLink($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Link $result */
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
    $formattedParent = ObservabilityClient::datasetName(
        '[PROJECT]',
        '[LOCATION]',
        '[BUCKET]',
        '[DATASET]'
    );
    $linkId = '[LINK_ID]';

    create_link_sample($formattedParent, $linkId);
}
// [END observability_v1_generated_Observability_CreateLink_sync]
