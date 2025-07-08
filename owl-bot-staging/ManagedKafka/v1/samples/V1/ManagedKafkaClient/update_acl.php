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

// [START managedkafka_v1_generated_ManagedKafka_UpdateAcl_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ManagedKafka\V1\Acl;
use Google\Cloud\ManagedKafka\V1\AclEntry;
use Google\Cloud\ManagedKafka\V1\Client\ManagedKafkaClient;
use Google\Cloud\ManagedKafka\V1\UpdateAclRequest;

/**
 * Updates the properties of a single acl.
 *
 * @param string $aclAclEntriesPrincipal      The principal. Specified as Google Cloud account, with the Kafka
 *                                            StandardAuthorizer prefix "User:". For example:
 *                                            "User:test-kafka-client&#64;test-project.iam.gserviceaccount.com".
 *                                            Can be the wildcard "User:*" to refer to all users.
 * @param string $aclAclEntriesPermissionType The permission type. Accepted values are (case insensitive):
 *                                            ALLOW, DENY.
 * @param string $aclAclEntriesOperation      The operation type. Allowed values are (case insensitive): ALL,
 *                                            READ, WRITE, CREATE, DELETE, ALTER, DESCRIBE, CLUSTER_ACTION,
 *                                            DESCRIBE_CONFIGS, ALTER_CONFIGS, and IDEMPOTENT_WRITE. See
 *                                            https://kafka.apache.org/documentation/#operations_resources_and_protocols
 *                                            for valid combinations of resource_type and operation for different Kafka
 *                                            API requests.
 * @param string $aclAclEntriesHost           The host. Must be set to "*" for Managed Service for Apache
 *                                            Kafka.
 */
function update_acl_sample(
    string $aclAclEntriesPrincipal,
    string $aclAclEntriesPermissionType,
    string $aclAclEntriesOperation,
    string $aclAclEntriesHost
): void {
    // Create a client.
    $managedKafkaClient = new ManagedKafkaClient();

    // Prepare the request message.
    $aclEntry = (new AclEntry())
        ->setPrincipal($aclAclEntriesPrincipal)
        ->setPermissionType($aclAclEntriesPermissionType)
        ->setOperation($aclAclEntriesOperation)
        ->setHost($aclAclEntriesHost);
    $aclAclEntries = [$aclEntry,];
    $acl = (new Acl())
        ->setAclEntries($aclAclEntries);
    $request = (new UpdateAclRequest())
        ->setAcl($acl);

    // Call the API and handle any network failures.
    try {
        /** @var Acl $response */
        $response = $managedKafkaClient->updateAcl($request);
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
    $aclAclEntriesPrincipal = '[PRINCIPAL]';
    $aclAclEntriesPermissionType = '[PERMISSION_TYPE]';
    $aclAclEntriesOperation = '[OPERATION]';
    $aclAclEntriesHost = '[HOST]';

    update_acl_sample(
        $aclAclEntriesPrincipal,
        $aclAclEntriesPermissionType,
        $aclAclEntriesOperation,
        $aclAclEntriesHost
    );
}
// [END managedkafka_v1_generated_ManagedKafka_UpdateAcl_sync]
