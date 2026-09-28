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

// [START ftp_v1_generated_CloudFtp_CreateServer_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Ftp\V1\Client\CloudFtpClient;
use Google\Cloud\Ftp\V1\CreateServerRequest;
use Google\Cloud\Ftp\V1\Server;
use Google\Cloud\Ftp\V1\Server\AccessType;
use Google\Rpc\Status;

/**
 * Creates a new Server in a given project and location.
 *
 * @param string $formattedParent  Value for parent. Please see
 *                                 {@see CloudFtpClient::locationName()} for help formatting this field.
 * @param string $serverId         A unique ID for the server. Must start with a lowercase letter,
 *                                 and end with a lowercase letter or number. Can contain lowercase letters,
 *                                 numbers, and hyphens. Maximum length is 30 characters.
 * @param int    $serverAccessType The access type of the Server.
 */
function create_server_sample(
    string $formattedParent,
    string $serverId,
    int $serverAccessType
): void {
    // Create a client.
    $cloudFtpClient = new CloudFtpClient();

    // Prepare the request message.
    $server = (new Server())
        ->setAccessType($serverAccessType);
    $request = (new CreateServerRequest())
        ->setParent($formattedParent)
        ->setServerId($serverId)
        ->setServer($server);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudFtpClient->createServer($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Server $result */
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
    $formattedParent = CloudFtpClient::locationName('[PROJECT]', '[LOCATION]');
    $serverId = '[SERVER_ID]';
    $serverAccessType = AccessType::ACCESS_TYPE_UNSPECIFIED;

    create_server_sample($formattedParent, $serverId, $serverAccessType);
}
// [END ftp_v1_generated_CloudFtp_CreateServer_sync]
