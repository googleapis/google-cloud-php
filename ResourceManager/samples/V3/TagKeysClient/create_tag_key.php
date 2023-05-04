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

// [START cloudresourcemanager_v3_generated_TagKeys_CreateTagKey_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ResourceManager\V3\TagKey;
use Google\Cloud\ResourceManager\V3\TagKeysClient;
use Google\Rpc\Status;

/**
 * Creates a new TagKey. If another request with the same parameters is
 * sent while the original request is in process, the second request
 * will receive an error. A maximum of 1000 TagKeys can exist under a parent
 * at any given time.
 *
 * @param string $tagKeyShortName Immutable. The user friendly name for a TagKey. The short name
 *                                should be unique for TagKeys within the same tag namespace.
 *
 *                                The short name must be 1-63 characters, beginning and ending with
 *                                an alphanumeric character ([a-z0-9A-Z]) with dashes (-), underscores (_),
 *                                dots (.), and alphanumerics between.
 */
function create_tag_key_sample(string $tagKeyShortName): void
{
    // Create a client.
    $tagKeysClient = new TagKeysClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $tagKey = (new TagKey())
        ->setShortName($tagKeyShortName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $tagKeysClient->createTagKey($tagKey);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var TagKey $result */
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
    $tagKeyShortName = '[SHORT_NAME]';

    create_tag_key_sample($tagKeyShortName);
}
// [END cloudresourcemanager_v3_generated_TagKeys_CreateTagKey_sync]
