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

// [START bigtable_v2_generated_Bigtable_OpenAuthorizedView_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\Bigtable\V2\Client\BigtableClient;
use Google\Cloud\Bigtable\V2\SessionRequest;
use Google\Cloud\Bigtable\V2\SessionResponse;

/**
 * This RPC is only intended to be used by the official Cloud Bigtable client
 * libraries to implement the Bigtable Session based protocol. It is subject
 * to change without notice.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function open_authorized_view_sample(): void
{
    // Create a client.
    $bigtableClient = new BigtableClient();

    // Prepare the request message.
    $request = new SessionRequest();

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $bigtableClient->openAuthorizedView();
        $stream->writeAll([$request,]);

        /** @var SessionResponse $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END bigtable_v2_generated_Bigtable_OpenAuthorizedView_sync]
