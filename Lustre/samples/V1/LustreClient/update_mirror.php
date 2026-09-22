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

// [START lustre_v1_generated_Lustre_UpdateMirror_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Lustre\V1\Client\LustreClient;
use Google\Cloud\Lustre\V1\GcsPath;
use Google\Cloud\Lustre\V1\LustrePath;
use Google\Cloud\Lustre\V1\Mirror;
use Google\Cloud\Lustre\V1\Mirror\Direction;
use Google\Cloud\Lustre\V1\UpdateMirrorRequest;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single mirror.
 *
 * @param string $mirrorGcsPathUri The URI to a Cloud Storage bucket, or a path within a bucket,
 *                                 using the format `gs://<bucket_name>/<optional_path_inside_bucket>/`. If a
 *                                 path inside the bucket is specified, it must end with a forward slash
 *                                 (`/`).
 * @param int    $mirrorDirection  Immutable. Represents the direction of the mirror.
 */
function update_mirror_sample(string $mirrorGcsPathUri, int $mirrorDirection): void
{
    // Create a client.
    $lustreClient = new LustreClient();

    // Prepare the request message.
    $mirrorGcsPath = (new GcsPath())
        ->setUri($mirrorGcsPathUri);
    $mirrorLustrePath = new LustrePath();
    $mirror = (new Mirror())
        ->setGcsPath($mirrorGcsPath)
        ->setLustrePath($mirrorLustrePath)
        ->setDirection($mirrorDirection);
    $request = (new UpdateMirrorRequest())
        ->setMirror($mirror);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $lustreClient->updateMirror($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Mirror $result */
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
    $mirrorGcsPathUri = '[URI]';
    $mirrorDirection = Direction::DIRECTION_UNSPECIFIED;

    update_mirror_sample($mirrorGcsPathUri, $mirrorDirection);
}
// [END lustre_v1_generated_Lustre_UpdateMirror_sync]
