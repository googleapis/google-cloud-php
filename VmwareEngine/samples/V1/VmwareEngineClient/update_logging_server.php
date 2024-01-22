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

// [START vmwareengine_v1_generated_VmwareEngine_UpdateLoggingServer_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\LoggingServer;
use Google\Cloud\VmwareEngine\V1\LoggingServer\Protocol;
use Google\Cloud\VmwareEngine\V1\LoggingServer\SourceType;
use Google\Cloud\VmwareEngine\V1\UpdateLoggingServerRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single logging server.
 * Only fields specified in `update_mask` are applied.
 *
 * @param string $loggingServerHostname   Fully-qualified domain name (FQDN) or IP Address of the logging
 *                                        server.
 * @param int    $loggingServerPort       Port number at which the logging server receives logs.
 * @param int    $loggingServerProtocol   Protocol used by vCenter to send logs to a logging server.
 * @param int    $loggingServerSourceType The type of component that produces logs that will be forwarded
 *                                        to this logging server.
 */
function update_logging_server_sample(
    string $loggingServerHostname,
    int $loggingServerPort,
    int $loggingServerProtocol,
    int $loggingServerSourceType
): void {
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $loggingServer = (new LoggingServer())
        ->setHostname($loggingServerHostname)
        ->setPort($loggingServerPort)
        ->setProtocol($loggingServerProtocol)
        ->setSourceType($loggingServerSourceType);
    $request = (new UpdateLoggingServerRequest())
        ->setUpdateMask($updateMask)
        ->setLoggingServer($loggingServer);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmwareEngineClient->updateLoggingServer($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var LoggingServer $result */
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
    $loggingServerHostname = '[HOSTNAME]';
    $loggingServerPort = 0;
    $loggingServerProtocol = Protocol::PROTOCOL_UNSPECIFIED;
    $loggingServerSourceType = SourceType::SOURCE_TYPE_UNSPECIFIED;

    update_logging_server_sample(
        $loggingServerHostname,
        $loggingServerPort,
        $loggingServerProtocol,
        $loggingServerSourceType
    );
}
// [END vmwareengine_v1_generated_VmwareEngine_UpdateLoggingServer_sync]
