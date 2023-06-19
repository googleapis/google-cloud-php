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

// [START migrationcenter_v1_generated_MigrationCenter_CreateSource_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\MigrationCenter\V1\Client\MigrationCenterClient;
use Google\Cloud\MigrationCenter\V1\CreateSourceRequest;
use Google\Cloud\MigrationCenter\V1\Source;
use Google\Rpc\Status;

/**
 * Creates a new source in a given project and location.
 *
 * @param string $formattedParent Value for parent. Please see
 *                                {@see MigrationCenterClient::locationName()} for help formatting this field.
 * @param string $sourceId        User specified ID for the source. It will become the last
 *                                component of the source name. The ID must be unique within the project,
 *                                must conform with RFC-1034, is restricted to lower-cased letters, and has a
 *                                maximum length of 63 characters. The ID must match the regular expression:
 *                                `[a-z]([a-z0-9-]{0,61}[a-z0-9])?`.
 */
function create_source_sample(string $formattedParent, string $sourceId): void
{
    // Create a client.
    $migrationCenterClient = new MigrationCenterClient();

    // Prepare the request message.
    $source = new Source();
    $request = (new CreateSourceRequest())
        ->setParent($formattedParent)
        ->setSourceId($sourceId)
        ->setSource($source);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $migrationCenterClient->createSource($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Source $result */
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
    $formattedParent = MigrationCenterClient::locationName('[PROJECT]', '[LOCATION]');
    $sourceId = '[SOURCE_ID]';

    create_source_sample($formattedParent, $sourceId);
}
// [END migrationcenter_v1_generated_MigrationCenter_CreateSource_sync]
