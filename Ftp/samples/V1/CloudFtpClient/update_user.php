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

// [START ftp_v1_generated_CloudFtp_UpdateUser_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Ftp\V1\Client\CloudFtpClient;
use Google\Cloud\Ftp\V1\StorageDirectoryMapping;
use Google\Cloud\Ftp\V1\StorageDirectoryMapping\Permission;
use Google\Cloud\Ftp\V1\UpdateUserRequest;
use Google\Cloud\Ftp\V1\User;
use Google\Cloud\Ftp\V1\UserCredential;
use Google\Cloud\Ftp\V1\UserCredential\Type;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single User.
 *
 * @param string $userCustomerServiceAccount             Service account in customer project attached to this SFTP User.
 * @param string $userUserCredentialsCredentialName      Name of the user credential.
 * @param int    $userUserCredentialsCredentialType      Type of credential.
 * @param string $userStorageDirectoryMappingsBucket     Name of the bucket.
 * @param string $userStorageDirectoryMappingsDirectory  Directory where the user lands in the SFTP server.
 * @param int    $userStorageDirectoryMappingsPermission Permission to the bucket.
 */
function update_user_sample(
    string $userCustomerServiceAccount,
    string $userUserCredentialsCredentialName,
    int $userUserCredentialsCredentialType,
    string $userStorageDirectoryMappingsBucket,
    string $userStorageDirectoryMappingsDirectory,
    int $userStorageDirectoryMappingsPermission
): void {
    // Create a client.
    $cloudFtpClient = new CloudFtpClient();

    // Prepare the request message.
    $userCredential = (new UserCredential())
        ->setCredentialName($userUserCredentialsCredentialName)
        ->setCredentialType($userUserCredentialsCredentialType);
    $userUserCredentials = [$userCredential,];
    $storageDirectoryMapping = (new StorageDirectoryMapping())
        ->setBucket($userStorageDirectoryMappingsBucket)
        ->setDirectory($userStorageDirectoryMappingsDirectory)
        ->setPermission($userStorageDirectoryMappingsPermission);
    $userStorageDirectoryMappings = [$storageDirectoryMapping,];
    $user = (new User())
        ->setCustomerServiceAccount($userCustomerServiceAccount)
        ->setUserCredentials($userUserCredentials)
        ->setStorageDirectoryMappings($userStorageDirectoryMappings);
    $request = (new UpdateUserRequest())
        ->setUser($user);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudFtpClient->updateUser($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var User $result */
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
    $userCustomerServiceAccount = '[CUSTOMER_SERVICE_ACCOUNT]';
    $userUserCredentialsCredentialName = '[CREDENTIAL_NAME]';
    $userUserCredentialsCredentialType = Type::TYPE_UNSPECIFIED;
    $userStorageDirectoryMappingsBucket = '[BUCKET]';
    $userStorageDirectoryMappingsDirectory = '[DIRECTORY]';
    $userStorageDirectoryMappingsPermission = Permission::PERMISSION_UNSPECIFIED;

    update_user_sample(
        $userCustomerServiceAccount,
        $userUserCredentialsCredentialName,
        $userUserCredentialsCredentialType,
        $userStorageDirectoryMappingsBucket,
        $userStorageDirectoryMappingsDirectory,
        $userStorageDirectoryMappingsPermission
    );
}
// [END ftp_v1_generated_CloudFtp_UpdateUser_sync]
