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

// [START ftp_v1_generated_CloudFtp_GetUser_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Ftp\V1\Client\CloudFtpClient;
use Google\Cloud\Ftp\V1\GetUserRequest;
use Google\Cloud\Ftp\V1\User;

/**
 * Gets details of a single User.
 *
 * @param string $formattedName Name of the resource
 *                              Please see {@see CloudFtpClient::userName()} for help formatting this field.
 */
function get_user_sample(string $formattedName): void
{
    // Create a client.
    $cloudFtpClient = new CloudFtpClient();

    // Prepare the request message.
    $request = (new GetUserRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var User $response */
        $response = $cloudFtpClient->getUser($request);
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
    $formattedName = CloudFtpClient::userName('[PROJECT]', '[LOCATION]', '[SERVER]', '[USER]');

    get_user_sample($formattedName);
}
// [END ftp_v1_generated_CloudFtp_GetUser_sync]
