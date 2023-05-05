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

// [START apigeeconnect_v1_generated_Tether_Egress_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\ApigeeConnect\V1\EgressRequest;
use Google\Cloud\ApigeeConnect\V1\EgressResponse;
use Google\Cloud\ApigeeConnect\V1\TetherClient;

/**
 * Egress streams egress requests and responses. Logically, this is not
 * actually a streaming request, but uses streaming as a mechanism to flip
 * the client-server relationship of gRPC so that the server can act as a
 * client.
 * The listener, the RPC server, accepts connections from the dialer,
 * the RPC client.
 * The listener streams http requests and the dialer streams http responses.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function egress_sample(): void
{
    // Create a client.
    $tetherClient = new TetherClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $request = new EgressResponse();

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $tetherClient->egress();
        $stream->writeAll([$request,]);

        /** @var EgressRequest $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END apigeeconnect_v1_generated_Tether_Egress_sync]
