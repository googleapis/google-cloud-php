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

// [START baremetalsolution_v2_generated_BareMetalSolution_CreateSSHKey_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BareMetalSolution\V2\Client\BareMetalSolutionClient;
use Google\Cloud\BareMetalSolution\V2\CreateSSHKeyRequest;
use Google\Cloud\BareMetalSolution\V2\SSHKey;

/**
 * Register a public SSH key in the specified project for use with the
 * interactive serial console feature.
 *
 * @param string $formattedParent The parent containing the SSH keys. Please see
 *                                {@see BareMetalSolutionClient::locationName()} for help formatting this field.
 * @param string $sshKeyId        The ID to use for the key, which will become the final component
 *                                of the key's resource name.
 *
 *                                This value must match the regex:
 *                                [a-zA-Z0-9&#64;.\-_]{1,64}
 */
function create_ssh_key_sample(string $formattedParent, string $sshKeyId): void
{
    // Create a client.
    $bareMetalSolutionClient = new BareMetalSolutionClient();

    // Prepare the request message.
    $sshKey = new SSHKey();
    $request = (new CreateSSHKeyRequest())
        ->setParent($formattedParent)
        ->setSshKey($sshKey)
        ->setSshKeyId($sshKeyId);

    // Call the API and handle any network failures.
    try {
        /** @var SSHKey $response */
        $response = $bareMetalSolutionClient->createSSHKey($request);
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
    $formattedParent = BareMetalSolutionClient::locationName('[PROJECT]', '[LOCATION]');
    $sshKeyId = '[SSH_KEY_ID]';

    create_ssh_key_sample($formattedParent, $sshKeyId);
}
// [END baremetalsolution_v2_generated_BareMetalSolution_CreateSSHKey_sync]
