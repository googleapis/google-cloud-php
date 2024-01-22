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

// [START cloudkms_v1_generated_KeyManagementService_CreateImportJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\Client\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\CreateImportJobRequest;
use Google\Cloud\Kms\V1\ImportJob;
use Google\Cloud\Kms\V1\ImportJob\ImportMethod;
use Google\Cloud\Kms\V1\ProtectionLevel;

/**
 * Create a new [ImportJob][google.cloud.kms.v1.ImportJob] within a
 * [KeyRing][google.cloud.kms.v1.KeyRing].
 *
 * [ImportJob.import_method][google.cloud.kms.v1.ImportJob.import_method] is
 * required.
 *
 * @param string $formattedParent          The [name][google.cloud.kms.v1.KeyRing.name] of the
 *                                         [KeyRing][google.cloud.kms.v1.KeyRing] associated with the
 *                                         [ImportJobs][google.cloud.kms.v1.ImportJob]. Please see
 *                                         {@see KeyManagementServiceClient::keyRingName()} for help formatting this field.
 * @param string $importJobId              It must be unique within a KeyRing and match the regular
 *                                         expression `[a-zA-Z0-9_-]{1,63}`
 * @param int    $importJobImportMethod    Immutable. The wrapping method to be used for incoming key
 *                                         material.
 * @param int    $importJobProtectionLevel Immutable. The protection level of the
 *                                         [ImportJob][google.cloud.kms.v1.ImportJob]. This must match the
 *                                         [protection_level][google.cloud.kms.v1.CryptoKeyVersionTemplate.protection_level]
 *                                         of the [version_template][google.cloud.kms.v1.CryptoKey.version_template]
 *                                         on the [CryptoKey][google.cloud.kms.v1.CryptoKey] you attempt to import
 *                                         into.
 */
function create_import_job_sample(
    string $formattedParent,
    string $importJobId,
    int $importJobImportMethod,
    int $importJobProtectionLevel
): void {
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Prepare the request message.
    $importJob = (new ImportJob())
        ->setImportMethod($importJobImportMethod)
        ->setProtectionLevel($importJobProtectionLevel);
    $request = (new CreateImportJobRequest())
        ->setParent($formattedParent)
        ->setImportJobId($importJobId)
        ->setImportJob($importJob);

    // Call the API and handle any network failures.
    try {
        /** @var ImportJob $response */
        $response = $keyManagementServiceClient->createImportJob($request);
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
    $formattedParent = KeyManagementServiceClient::keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
    $importJobId = '[IMPORT_JOB_ID]';
    $importJobImportMethod = ImportMethod::IMPORT_METHOD_UNSPECIFIED;
    $importJobProtectionLevel = ProtectionLevel::PROTECTION_LEVEL_UNSPECIFIED;

    create_import_job_sample(
        $formattedParent,
        $importJobId,
        $importJobImportMethod,
        $importJobProtectionLevel
    );
}
// [END cloudkms_v1_generated_KeyManagementService_CreateImportJob_sync]
