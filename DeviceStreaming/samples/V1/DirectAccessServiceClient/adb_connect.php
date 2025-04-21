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

// [START devicestreaming_v1_generated_DirectAccessService_AdbConnect_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\DeviceStreaming\V1\AdbMessage;
use Google\Cloud\DeviceStreaming\V1\Client\DirectAccessServiceClient;
use Google\Cloud\DeviceStreaming\V1\DeviceMessage;

/**
 * Exposes an ADB connection if the device supports ADB.
 * gRPC headers are used to authenticate the Connect RPC, as well as
 * associate to a particular DeviceSession.
 * In particular, the user must specify the "X-Omnilab-Session-Name" header.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function adb_connect_sample(): void
{
    // Create a client.
    $directAccessServiceClient = new DirectAccessServiceClient();

    // Prepare the request message.
    $request = new AdbMessage();

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $directAccessServiceClient->adbConnect();
        $stream->writeAll([$request,]);

        /** @var DeviceMessage $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END devicestreaming_v1_generated_DirectAccessService_AdbConnect_sync]
