<?php
/*
 * Copyright 2023 Google LLC
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

// [START jobs_v4beta1_generated_CompanyService_CreateCompany_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Talent\V4beta1\Company;
use Google\Cloud\Talent\V4beta1\CompanyServiceClient;

/**
 * Creates a new company entity.
 *
 * @param string $formattedParent    Resource name of the tenant under which the company is created.
 *
 *                                   The format is "projects/{project_id}/tenants/{tenant_id}", for example,
 *                                   "projects/foo/tenant/bar". If tenant id is unspecified, a default tenant
 *                                   is created, for example, "projects/foo". Please see
 *                                   {@see CompanyServiceClient::projectName()} for help formatting this field.
 * @param string $companyDisplayName The display name of the company, for example, "Google LLC".
 * @param string $companyExternalId  Client side company identifier, used to uniquely identify the
 *                                   company.
 *
 *                                   The maximum number of allowed characters is 255.
 */
function create_company_sample(
    string $formattedParent,
    string $companyDisplayName,
    string $companyExternalId
): void {
    // Create a client.
    $companyServiceClient = new CompanyServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $company = (new Company())
        ->setDisplayName($companyDisplayName)
        ->setExternalId($companyExternalId);

    // Call the API and handle any network failures.
    try {
        /** @var Company $response */
        $response = $companyServiceClient->createCompany($formattedParent, $company);
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
    $formattedParent = CompanyServiceClient::projectName('[PROJECT]');
    $companyDisplayName = '[DISPLAY_NAME]';
    $companyExternalId = '[EXTERNAL_ID]';

    create_company_sample($formattedParent, $companyDisplayName, $companyExternalId);
}
// [END jobs_v4beta1_generated_CompanyService_CreateCompany_sync]
