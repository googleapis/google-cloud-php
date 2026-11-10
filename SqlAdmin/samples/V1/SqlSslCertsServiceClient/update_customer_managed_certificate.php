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

// [START sqladmin_v1_generated_SqlSslCertsService_UpdateCustomerManagedCertificate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Sql\V1\CertificateType;
use Google\Cloud\Sql\V1\Client\SqlSslCertsServiceClient;
use Google\Cloud\Sql\V1\CustomerManagedCertificate;
use Google\Cloud\Sql\V1\CustomerManagedCertificateConfig;
use Google\Cloud\Sql\V1\Intent;
use Google\Cloud\Sql\V1\Operation;
use Google\Cloud\Sql\V1\UpdateCustomerManagedCertificateRequest;

/**
 * Upload and update customer managed certificate bundle for an existing Cloud
 * SQL instance.
 *
 * @param string $instance                                                                   Cloud SQL instance ID. This does not include the project ID.
 * @param string $project                                                                    Project ID of the project that contains the instance.
 * @param int    $customerManagedCertificateConfigIntent                                     The intent for this customer managed certificate configuration.
 * @param int    $customerManagedCertificateConfigCustomerManagedCertificatesCertificateType The certificate type.
 * @param string $customerManagedCertificateConfigCustomerManagedCertificatesContent         Input only. The PEM-encoded certificate or key content in base64
 *                                                                                           format.
 * @param string $certificateBundle                                                          Name tag of the customer managed certificate bundle to update. It
 *                                                                                           must start with a letter, be alphanumeric, and have a maximum length of 10
 *                                                                                           characters.
 */
function update_customer_managed_certificate_sample(
    string $instance,
    string $project,
    int $customerManagedCertificateConfigIntent,
    int $customerManagedCertificateConfigCustomerManagedCertificatesCertificateType,
    string $customerManagedCertificateConfigCustomerManagedCertificatesContent,
    string $certificateBundle
): void {
    // Create a client.
    $sqlSslCertsServiceClient = new SqlSslCertsServiceClient();

    // Prepare the request message.
    $customerManagedCertificate = (new CustomerManagedCertificate())
        ->setCertificateType($customerManagedCertificateConfigCustomerManagedCertificatesCertificateType)
        ->setContent($customerManagedCertificateConfigCustomerManagedCertificatesContent);
    $customerManagedCertificateConfigCustomerManagedCertificates = [$customerManagedCertificate];
    $customerManagedCertificateConfig = (new CustomerManagedCertificateConfig())
        ->setIntent($customerManagedCertificateConfigIntent)
        ->setCustomerManagedCertificates($customerManagedCertificateConfigCustomerManagedCertificates);
    $request = (new UpdateCustomerManagedCertificateRequest())
        ->setInstance($instance)
        ->setProject($project)
        ->setCustomerManagedCertificateConfig($customerManagedCertificateConfig)
        ->setCertificateBundle($certificateBundle);

    // Call the API and handle any network failures.
    try {
        /** @var Operation $response */
        $response = $sqlSslCertsServiceClient->updateCustomerManagedCertificate($request);
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
    $instance = '[INSTANCE]';
    $project = '[PROJECT]';
    $customerManagedCertificateConfigIntent = Intent::INTENT_UNSPECIFIED;
    $customerManagedCertificateConfigCustomerManagedCertificatesCertificateType = CertificateType::CERTIFICATE_TYPE_UNSPECIFIED;
    $customerManagedCertificateConfigCustomerManagedCertificatesContent = '...';
    $certificateBundle = '[CERTIFICATE_BUNDLE]';

    update_customer_managed_certificate_sample(
        $instance,
        $project,
        $customerManagedCertificateConfigIntent,
        $customerManagedCertificateConfigCustomerManagedCertificatesCertificateType,
        $customerManagedCertificateConfigCustomerManagedCertificatesContent,
        $certificateBundle
    );
}
// [END sqladmin_v1_generated_SqlSslCertsService_UpdateCustomerManagedCertificate_sync]
