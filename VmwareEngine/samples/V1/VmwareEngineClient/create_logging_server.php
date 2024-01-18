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

// [START vmwareengine_v1_generated_VmwareEngine_CreateLoggingServer_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\CreateLoggingServerRequest;
use Google\Cloud\VmwareEngine\V1\LoggingServer;
use Google\Cloud\VmwareEngine\V1\LoggingServer\Protocol;
use Google\Cloud\VmwareEngine\V1\LoggingServer\SourceType;
use Google\Rpc\Status;

/**
 * Create a new logging server for a given private cloud.
 *
 * @param string $formattedParent         The resource name of the private cloud
 *                                        to create a new Logging Server in.
 *                                        Resource names are schemeless URIs that follow the conventions in
 *                                        https://cloud.google.com/apis/design/resource_names.
 *                                        For example:
 *                                        `projects/my-project/locations/us-central1-a/privateClouds/my-cloud`
 *                                        Please see {@see VmwareEngineClient::privateCloudName()} for help formatting this field.
 * @param string $loggingServerHostname   Fully-qualified domain name (FQDN) or IP Address of the logging
 *                                        server.
 * @param int    $loggingServerPort       Port number at which the logging server receives logs.
 * @param int    $loggingServerProtocol   Protocol used by vCenter to send logs to a logging server.
 * @param int    $loggingServerSourceType The type of component that produces logs that will be forwarded
 *                                        to this logging server.
 * @param string $loggingServerId         The user-provided identifier of the `LoggingServer` to be
 *                                        created. This identifier must be unique among `LoggingServer` resources
 *                                        within the parent and becomes the final token in the name URI.
 *                                        The identifier must meet the following requirements:
 *
 *                                        * Only contains 1-63 alphanumeric characters and hyphens
 *                                        * Begins with an alphabetical character
 *                                        * Ends with a non-hyphen character
 *                                        * Not formatted as a UUID
 *                                        * Complies with [RFC 1034](https://datatracker.ietf.org/doc/html/rfc1034)
 *                                        (section 3.5)
 */
function create_logging_server_sample(
    string $formattedParent,
    string $loggingServerHostname,
    int $loggingServerPort,
    int $loggingServerProtocol,
    int $loggingServerSourceType,
    string $loggingServerId
): void {
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $loggingServer = (new LoggingServer())
        ->setHostname($loggingServerHostname)
        ->setPort($loggingServerPort)
        ->setProtocol($loggingServerProtocol)
        ->setSourceType($loggingServerSourceType);
    $request = (new CreateLoggingServerRequest())
        ->setParent($formattedParent)
        ->setLoggingServer($loggingServer)
        ->setLoggingServerId($loggingServerId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmwareEngineClient->createLoggingServer($request);
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
    $formattedParent = VmwareEngineClient::privateCloudName(
        '[PROJECT]',
        '[LOCATION]',
        '[PRIVATE_CLOUD]'
    );
    $loggingServerHostname = '[HOSTNAME]';
    $loggingServerPort = 0;
    $loggingServerProtocol = Protocol::PROTOCOL_UNSPECIFIED;
    $loggingServerSourceType = SourceType::SOURCE_TYPE_UNSPECIFIED;
    $loggingServerId = '[LOGGING_SERVER_ID]';

    create_logging_server_sample(
        $formattedParent,
        $loggingServerHostname,
        $loggingServerPort,
        $loggingServerProtocol,
        $loggingServerSourceType,
        $loggingServerId
    );
}
// [END vmwareengine_v1_generated_VmwareEngine_CreateLoggingServer_sync]
