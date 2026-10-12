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

// [START chronicle_v1_generated_FeedsService_GenerateSecret_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\FeedsServiceClient;
use Google\Cloud\Chronicle\V1\GenerateSecretRequest;
use Google\Cloud\Chronicle\V1\GenerateSecretResponse;

/**
 * Generates a new secret for https push feeds which do not support jwt
 * tokens. Secrets once generated should be copied and stored in safe place
 * to be used while configuring https push feeds.Please note that you can
 * always generate a new secret again for a feed using this API but it will
 * invalidate the previously generated secret for the feed.
 *
 * @param string $formattedName The name of the feed to for which to generate secret.
 *                              Format:
 *                              projects/{project}/locations/{location}/instances/{instance}/feeds/{feed}
 *                              Please see {@see FeedsServiceClient::feedName()} for help formatting this field.
 */
function generate_secret_sample(string $formattedName): void
{
    // Create a client.
    $feedsServiceClient = new FeedsServiceClient();

    // Prepare the request message.
    $request = (new GenerateSecretRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateSecretResponse $response */
        $response = $feedsServiceClient->generateSecret($request);
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
    $formattedName = FeedsServiceClient::feedName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[FEED]');

    generate_secret_sample($formattedName);
}
// [END chronicle_v1_generated_FeedsService_GenerateSecret_sync]
