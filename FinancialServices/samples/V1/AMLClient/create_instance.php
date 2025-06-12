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

// [START financialservices_v1_generated_AML_CreateInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\FinancialServices\V1\Client\AMLClient;
use Google\Cloud\FinancialServices\V1\CreateInstanceRequest;
use Google\Cloud\FinancialServices\V1\Instance;
use Google\Rpc\Status;

/**
 * Creates an instance.
 *
 * @param string $formattedParent The parent of the Instance is the location for that Instance.
 *                                Every location has exactly one instance. Please see
 *                                {@see AMLClient::locationName()} for help formatting this field.
 * @param string $instanceId      The resource id of the instance.
 * @param string $instanceKmsKey  The KMS key name used for CMEK (encryption-at-rest).
 *                                format:
 *                                `projects/{project}/locations/{location}/keyRings/{keyRing}/cryptoKeys/{cryptoKey}`
 *                                VPC-SC restrictions apply.
 */
function create_instance_sample(
    string $formattedParent,
    string $instanceId,
    string $instanceKmsKey
): void {
    // Create a client.
    $aMLClient = new AMLClient();

    // Prepare the request message.
    $instance = (new Instance())
        ->setKmsKey($instanceKmsKey);
    $request = (new CreateInstanceRequest())
        ->setParent($formattedParent)
        ->setInstanceId($instanceId)
        ->setInstance($instance);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $aMLClient->createInstance($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Instance $result */
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
    $formattedParent = AMLClient::locationName('[PROJECT]', '[LOCATION]');
    $instanceId = '[INSTANCE_ID]';
    $instanceKmsKey = '[KMS_KEY]';

    create_instance_sample($formattedParent, $instanceId, $instanceKmsKey);
}
// [END financialservices_v1_generated_AML_CreateInstance_sync]
