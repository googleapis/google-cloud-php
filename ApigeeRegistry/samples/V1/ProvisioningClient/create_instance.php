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

// [START apigeeregistry_v1_generated_Provisioning_CreateInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ApigeeRegistry\V1\Instance;
use Google\Cloud\ApigeeRegistry\V1\Instance\Config;
use Google\Cloud\ApigeeRegistry\V1\ProvisioningClient;
use Google\Rpc\Status;

/**
 * Provisions instance resources for the Registry.
 *
 * @param string $formattedParent           Parent resource of the Instance, of the form: `projects/&#42;/locations/*`
 *                                          Please see {@see ProvisioningClient::locationName()} for help formatting this field.
 * @param string $instanceId                Identifier to assign to the Instance. Must be unique within scope of the
 *                                          parent resource.
 * @param string $instanceConfigCmekKeyName The Customer Managed Encryption Key (CMEK) used for data encryption.
 *                                          The CMEK name should follow the format of
 *                                          `projects/([^/]+)/locations/([^/]+)/keyRings/([^/]+)/cryptoKeys/([^/]+)`,
 *                                          where the `location` must match InstanceConfig.location.
 */
function create_instance_sample(
    string $formattedParent,
    string $instanceId,
    string $instanceConfigCmekKeyName
): void {
    // Create a client.
    $provisioningClient = new ProvisioningClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $instanceConfig = (new Config())
        ->setCmekKeyName($instanceConfigCmekKeyName);
    $instance = (new Instance())
        ->setConfig($instanceConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $provisioningClient->createInstance($formattedParent, $instanceId, $instance);
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
    $formattedParent = ProvisioningClient::locationName('[PROJECT]', '[LOCATION]');
    $instanceId = '[INSTANCE_ID]';
    $instanceConfigCmekKeyName = '[CMEK_KEY_NAME]';

    create_instance_sample($formattedParent, $instanceId, $instanceConfigCmekKeyName);
}
// [END apigeeregistry_v1_generated_Provisioning_CreateInstance_sync]
