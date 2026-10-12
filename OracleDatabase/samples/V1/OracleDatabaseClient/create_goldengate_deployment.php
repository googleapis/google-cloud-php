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

// [START oracledatabase_v1_generated_OracleDatabase_CreateGoldengateDeployment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\CreateGoldengateDeploymentRequest;
use Google\Cloud\OracleDatabase\V1\GoldengateDeployment;
use Google\Cloud\OracleDatabase\V1\GoldengateDeploymentProperties;
use Google\Cloud\OracleDatabase\V1\GoldengateOggDeployment;
use Google\Rpc\Status;

/**
 * Creates a new GoldengateDeployment in a given project and location.
 *
 * @param string $formattedParent                                    The value for parent of the GoldengateDeployment in the following
 *                                                                   format: projects/{project}/locations/{location}. Please see
 *                                                                   {@see OracleDatabaseClient::locationName()} for help formatting this field.
 * @param string $goldengateDeploymentId                             The ID of the GoldengateDeployment to create. This value is
 *                                                                   restricted to (^[a-z]([a-z0-9-]{0,61}[a-z0-9])?$) and must be a maximum of
 *                                                                   63 characters in length. The value must start with a letter and end with a
 *                                                                   letter or a number.
 * @param string $goldengateDeploymentPropertiesDeploymentType       A valid Goldengate Deployment type. For a list of supported
 *                                                                   types, use the `ListGoldengateDeploymentTypes` operation.
 * @param string $goldengateDeploymentPropertiesOggDataDeployment    The name given to the Goldengate service deployment. The name
 *                                                                   must be 1 to 32 characters long, must contain only alphanumeric characters
 *                                                                   and must start with a letter.
 * @param string $goldengateDeploymentPropertiesOggDataAdminUsername The Goldengate deployment console username.
 * @param string $formattedGoldengateDeploymentOdbSubnet             The name of the OdbSubnet associated with the
 *                                                                   GoldengateDeployment for IP allocation. Please see
 *                                                                   {@see OracleDatabaseClient::odbSubnetName()} for help formatting this field.
 * @param string $goldengateDeploymentDisplayName                    The display name for the GoldengateDeployment.
 */
function create_goldengate_deployment_sample(
    string $formattedParent,
    string $goldengateDeploymentId,
    string $goldengateDeploymentPropertiesDeploymentType,
    string $goldengateDeploymentPropertiesOggDataDeployment,
    string $goldengateDeploymentPropertiesOggDataAdminUsername,
    string $formattedGoldengateDeploymentOdbSubnet,
    string $goldengateDeploymentDisplayName
): void {
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $goldengateDeploymentPropertiesOggData = (new GoldengateOggDeployment())
        ->setDeployment($goldengateDeploymentPropertiesOggDataDeployment)
        ->setAdminUsername($goldengateDeploymentPropertiesOggDataAdminUsername);
    $goldengateDeploymentProperties = (new GoldengateDeploymentProperties())
        ->setDeploymentType($goldengateDeploymentPropertiesDeploymentType)
        ->setOggData($goldengateDeploymentPropertiesOggData);
    $goldengateDeployment = (new GoldengateDeployment())
        ->setProperties($goldengateDeploymentProperties)
        ->setOdbSubnet($formattedGoldengateDeploymentOdbSubnet)
        ->setDisplayName($goldengateDeploymentDisplayName);
    $request = (new CreateGoldengateDeploymentRequest())
        ->setParent($formattedParent)
        ->setGoldengateDeploymentId($goldengateDeploymentId)
        ->setGoldengateDeployment($goldengateDeployment);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $oracleDatabaseClient->createGoldengateDeployment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GoldengateDeployment $result */
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
    $formattedParent = OracleDatabaseClient::locationName('[PROJECT]', '[LOCATION]');
    $goldengateDeploymentId = '[GOLDENGATE_DEPLOYMENT_ID]';
    $goldengateDeploymentPropertiesDeploymentType = '[DEPLOYMENT_TYPE]';
    $goldengateDeploymentPropertiesOggDataDeployment = '[DEPLOYMENT]';
    $goldengateDeploymentPropertiesOggDataAdminUsername = '[ADMIN_USERNAME]';
    $formattedGoldengateDeploymentOdbSubnet = OracleDatabaseClient::odbSubnetName(
        '[PROJECT]',
        '[LOCATION]',
        '[ODB_NETWORK]',
        '[ODB_SUBNET]'
    );
    $goldengateDeploymentDisplayName = '[DISPLAY_NAME]';

    create_goldengate_deployment_sample(
        $formattedParent,
        $goldengateDeploymentId,
        $goldengateDeploymentPropertiesDeploymentType,
        $goldengateDeploymentPropertiesOggDataDeployment,
        $goldengateDeploymentPropertiesOggDataAdminUsername,
        $formattedGoldengateDeploymentOdbSubnet,
        $goldengateDeploymentDisplayName
    );
}
// [END oracledatabase_v1_generated_OracleDatabase_CreateGoldengateDeployment_sync]
