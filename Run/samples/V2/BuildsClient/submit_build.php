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

// [START run_v2_generated_Builds_SubmitBuild_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Run\V2\Client\BuildsClient;
use Google\Cloud\Run\V2\StorageSource;
use Google\Cloud\Run\V2\SubmitBuildRequest;
use Google\Cloud\Run\V2\SubmitBuildResponse;

/**
 * Submits a build in a given project.
 *
 * @param string $parent              The project and location to build in. Location must be a region,
 *                                    e.g., 'us-central1' or 'global' if the global builder is to be used.
 *                                    Format:
 *                                    `projects/{project}/locations/{location}`
 * @param string $storageSourceBucket Google Cloud Storage bucket containing the source (see
 *                                    [Bucket Name
 *                                    Requirements](https://cloud.google.com/storage/docs/bucket-naming#requirements)).
 * @param string $storageSourceObject Google Cloud Storage object containing the source.
 *
 *                                    This object must be a gzipped archive file (`.tar.gz`) containing source to
 *                                    build.
 * @param string $imageUri            Artifact Registry URI to store the built image.
 */
function submit_build_sample(
    string $parent,
    string $storageSourceBucket,
    string $storageSourceObject,
    string $imageUri
): void {
    // Create a client.
    $buildsClient = new BuildsClient();

    // Prepare the request message.
    $storageSource = (new StorageSource())
        ->setBucket($storageSourceBucket)
        ->setObject($storageSourceObject);
    $request = (new SubmitBuildRequest())
        ->setParent($parent)
        ->setStorageSource($storageSource)
        ->setImageUri($imageUri);

    // Call the API and handle any network failures.
    try {
        /** @var SubmitBuildResponse $response */
        $response = $buildsClient->submitBuild($request);
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
    $parent = '[PARENT]';
    $storageSourceBucket = '[BUCKET]';
    $storageSourceObject = '[OBJECT]';
    $imageUri = '[IMAGE_URI]';

    submit_build_sample($parent, $storageSourceBucket, $storageSourceObject, $imageUri);
}
// [END run_v2_generated_Builds_SubmitBuild_sync]
