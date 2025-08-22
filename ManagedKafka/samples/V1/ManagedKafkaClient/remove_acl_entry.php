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

// [START managedkafka_v1_generated_ManagedKafka_RemoveAclEntry_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ManagedKafka\V1\AclEntry;
use Google\Cloud\ManagedKafka\V1\Client\ManagedKafkaClient;
use Google\Cloud\ManagedKafka\V1\RemoveAclEntryRequest;
use Google\Cloud\ManagedKafka\V1\RemoveAclEntryResponse;

/**
 * Incremental update: Removes an acl entry from an acl. Deletes the acl if
 * its acl entries become empty (i.e. if the removed entry was the last one in
 * the acl).
 *
 * @param string $formattedAcl           The name of the acl to remove the acl entry from.
 *                                       Structured like:
 *                                       `projects/{project}/locations/{location}/clusters/{cluster}/acls/{acl_id}`.
 *
 *                                       The structure of `acl_id` defines the Resource Pattern (resource_type,
 *                                       resource_name, pattern_type) of the acl. See `Acl.name` for
 *                                       details. Please see
 *                                       {@see ManagedKafkaClient::aclName()} for help formatting this field.
 * @param string $aclEntryPrincipal      The principal. Specified as Google Cloud account, with the Kafka
 *                                       StandardAuthorizer prefix "User:". For example:
 *                                       "User:test-kafka-client&#64;test-project.iam.gserviceaccount.com".
 *                                       Can be the wildcard "User:*" to refer to all users.
 * @param string $aclEntryPermissionType The permission type. Accepted values are (case insensitive):
 *                                       ALLOW, DENY.
 * @param string $aclEntryOperation      The operation type. Allowed values are (case insensitive): ALL,
 *                                       READ, WRITE, CREATE, DELETE, ALTER, DESCRIBE, CLUSTER_ACTION,
 *                                       DESCRIBE_CONFIGS, ALTER_CONFIGS, and IDEMPOTENT_WRITE. See
 *                                       https://kafka.apache.org/documentation/#operations_resources_and_protocols
 *                                       for valid combinations of resource_type and operation for different Kafka
 *                                       API requests.
 * @param string $aclEntryHost           The host. Must be set to "*" for Managed Service for Apache
 *                                       Kafka.
 */
function remove_acl_entry_sample(
    string $formattedAcl,
    string $aclEntryPrincipal,
    string $aclEntryPermissionType,
    string $aclEntryOperation,
    string $aclEntryHost
): void {
    // Create a client.
    $managedKafkaClient = new ManagedKafkaClient();

    // Prepare the request message.
    $aclEntry = (new AclEntry())
        ->setPrincipal($aclEntryPrincipal)
        ->setPermissionType($aclEntryPermissionType)
        ->setOperation($aclEntryOperation)
        ->setHost($aclEntryHost);
    $request = (new RemoveAclEntryRequest())
        ->setAcl($formattedAcl)
        ->setAclEntry($aclEntry);

    // Call the API and handle any network failures.
    try {
        /** @var RemoveAclEntryResponse $response */
        $response = $managedKafkaClient->removeAclEntry($request);
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
    $formattedAcl = ManagedKafkaClient::aclName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[ACL]');
    $aclEntryPrincipal = '[PRINCIPAL]';
    $aclEntryPermissionType = '[PERMISSION_TYPE]';
    $aclEntryOperation = '[OPERATION]';
    $aclEntryHost = '[HOST]';

    remove_acl_entry_sample(
        $formattedAcl,
        $aclEntryPrincipal,
        $aclEntryPermissionType,
        $aclEntryOperation,
        $aclEntryHost
    );
}
// [END managedkafka_v1_generated_ManagedKafka_RemoveAclEntry_sync]
