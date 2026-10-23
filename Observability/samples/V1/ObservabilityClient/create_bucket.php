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

// [START observability_v1_generated_Observability_CreateBucket_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Observability\V1\Bucket;
use Google\Cloud\Observability\V1\Client\ObservabilityClient;
use Google\Cloud\Observability\V1\CreateBucketRequest;
use Google\Rpc\Status;

/**
 * Create a new bucket.
 *
 * @param string $formattedParent Name of the project and location for the bucket. The format is:
 *
 *                                projects/[PROJECT_ID]/locations/[LOCATION]
 *                                Please see {@see ObservabilityClient::locationName()} for help formatting this field.
 * @param string $bucketId        Id of the bucket to create.
 */
function create_bucket_sample(string $formattedParent, string $bucketId): void
{
    // Create a client.
    $observabilityClient = new ObservabilityClient();

    // Prepare the request message.
    $bucket = new Bucket();
    $request = (new CreateBucketRequest())
        ->setParent($formattedParent)
        ->setBucketId($bucketId)
        ->setBucket($bucket);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $observabilityClient->createBucket($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Bucket $result */
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
    $formattedParent = ObservabilityClient::locationName('[PROJECT]', '[LOCATION]');
    $bucketId = '[BUCKET_ID]';

    create_bucket_sample($formattedParent, $bucketId);
}
// [END observability_v1_generated_Observability_CreateBucket_sync]
