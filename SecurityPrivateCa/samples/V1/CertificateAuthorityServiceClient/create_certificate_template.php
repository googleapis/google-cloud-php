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

// [START privateca_v1_generated_CertificateAuthorityService_CreateCertificateTemplate_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Security\PrivateCA\V1\CertificateAuthorityServiceClient;
use Google\Cloud\Security\PrivateCA\V1\CertificateTemplate;
use Google\Rpc\Status;

/**
 * Create a new [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate] in a given Project and Location.
 *
 * @param string $formattedParent       The resource name of the location associated with the
 *                                      [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate], in the format
 *                                      `projects/&#42;/locations/*`. Please see
 *                                      {@see CertificateAuthorityServiceClient::locationName()} for help formatting this field.
 * @param string $certificateTemplateId It must be unique within a location and match the regular
 *                                      expression `[a-zA-Z0-9_-]{1,63}`
 */
function create_certificate_template_sample(
    string $formattedParent,
    string $certificateTemplateId
): void {
    // Create a client.
    $certificateAuthorityServiceClient = new CertificateAuthorityServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $certificateTemplate = new CertificateTemplate();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $certificateAuthorityServiceClient->createCertificateTemplate(
            $formattedParent,
            $certificateTemplateId,
            $certificateTemplate
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var CertificateTemplate $result */
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
    $formattedParent = CertificateAuthorityServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $certificateTemplateId = '[CERTIFICATE_TEMPLATE_ID]';

    create_certificate_template_sample($formattedParent, $certificateTemplateId);
}
// [END privateca_v1_generated_CertificateAuthorityService_CreateCertificateTemplate_sync]
