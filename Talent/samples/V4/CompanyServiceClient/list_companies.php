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

// [START jobs_v4_generated_CompanyService_ListCompanies_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Talent\V4\Company;
use Google\Cloud\Talent\V4\CompanyServiceClient;

/**
 * Lists all companies associated with the project.
 *
 * @param string $formattedParent Resource name of the tenant under which the company is created.
 *
 *                                The format is "projects/{project_id}/tenants/{tenant_id}", for example,
 *                                "projects/foo/tenants/bar". Please see
 *                                {@see CompanyServiceClient::tenantName()} for help formatting this field.
 */
function list_companies_sample(string $formattedParent): void
{
    // Create a client.
    $companyServiceClient = new CompanyServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $companyServiceClient->listCompanies($formattedParent);

        /** @var Company $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = CompanyServiceClient::tenantName('[PROJECT]', '[TENANT]');

    list_companies_sample($formattedParent);
}
// [END jobs_v4_generated_CompanyService_ListCompanies_sync]
