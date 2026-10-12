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

// [START memorystore_v1beta_generated_Memorystore_StartMigration_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Memorystore\V1beta\Client\MemorystoreClient;
use Google\Cloud\Memorystore\V1beta\Instance;
use Google\Cloud\Memorystore\V1beta\SelfManagedSource;
use Google\Cloud\Memorystore\V1beta\StartMigrationRequest;
use Google\Rpc\Status;

/**
 * Initiates the migration of a source instance to the target Memorystore
 * instance.
 *
 * After the successful completion of this operation, the target instance
 * will:
 * 1. Set up replication with the source instance and replicate any writes to
 * the source instance.
 * 2. Only allow reads.
 *
 * @param string $selfManagedSourceIpAddress                  The IP address of the source instance.
 *                                                            This IP address should be a stable IP address that can be accessed by the
 *                                                            Memorystore instance throughout the migration process.
 * @param int    $selfManagedSourcePort                       The port of the source instance.
 *                                                            This port should be a stable port that can be accessed by the Memorystore
 *                                                            instance throughout the migration process.
 * @param string $formattedSelfManagedSourceNetworkAttachment The resource name of the Private Service Connect Network
 *                                                            Attachment used to establish connectivity to the source instance. This
 *                                                            network attachment has the following requirements:
 *                                                            1. It must be in the same project as the Memorystore instance.
 *                                                            2. It must be in the same region as the Memorystore instance.
 *                                                            3. The subnet attached to the network attachment must be in the same VPC
 *                                                            network as the source instance nodes.
 *
 *                                                            Format:
 *                                                            projects/{project}/regions/{region}/networkAttachments/{network_attachment}
 *                                                            Please see {@see MemorystoreClient::networkAttachmentName()} for help formatting this field.
 * @param string $formattedName                               The resource name of the instance to start migration on.
 *                                                            Format: projects/{project}/locations/{location}/instances/{instance}
 *                                                            Please see {@see MemorystoreClient::instanceName()} for help formatting this field.
 */
function start_migration_sample(
    string $selfManagedSourceIpAddress,
    int $selfManagedSourcePort,
    string $formattedSelfManagedSourceNetworkAttachment,
    string $formattedName
): void {
    // Create a client.
    $memorystoreClient = new MemorystoreClient();

    // Prepare the request message.
    $selfManagedSource = (new SelfManagedSource())
        ->setIpAddress($selfManagedSourceIpAddress)
        ->setPort($selfManagedSourcePort)
        ->setNetworkAttachment($formattedSelfManagedSourceNetworkAttachment);
    $request = (new StartMigrationRequest())
        ->setSelfManagedSource($selfManagedSource)
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $memorystoreClient->startMigration($request);
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
    $selfManagedSourceIpAddress = '[IP_ADDRESS]';
    $selfManagedSourcePort = 0;
    $formattedSelfManagedSourceNetworkAttachment = MemorystoreClient::networkAttachmentName(
        '[PROJECT]',
        '[REGION]',
        '[NETWORK_ATTACHMENT]'
    );
    $formattedName = MemorystoreClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');

    start_migration_sample(
        $selfManagedSourceIpAddress,
        $selfManagedSourcePort,
        $formattedSelfManagedSourceNetworkAttachment,
        $formattedName
    );
}
// [END memorystore_v1beta_generated_Memorystore_StartMigration_sync]
