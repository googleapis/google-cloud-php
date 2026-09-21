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

// [START admanager_v1_generated_CompanyService_BatchUpdateCompanies_sync]
use Google\Ads\AdManager\V1\BatchUpdateCompaniesRequest;
use Google\Ads\AdManager\V1\BatchUpdateCompaniesResponse;
use Google\Ads\AdManager\V1\Client\CompanyServiceClient;
use Google\Ads\AdManager\V1\Company;
use Google\Ads\AdManager\V1\CompanyTypeEnum\CompanyType;
use Google\Ads\AdManager\V1\UpdateCompanyRequest;
use Google\ApiCore\ApiException;

/**
 * Batch updates [Company][google.ads.admanager.v1.Company] objects.
 *
 * @param string $formattedParent            The parent resource where [Companies][] will be updated.
 *                                           Format: `networks/{network_code}`
 *                                           The parent field in the UpdateCompanyRequest must match this
 *                                           field. Please see
 *                                           {@see CompanyServiceClient::networkName()} for help formatting this field.
 * @param string $requestsCompanyDisplayName The display name of the
 *                                           [Company][google.ads.admanager.v1.Company].
 *
 *                                           This value has a maximum length of 127 characters.
 * @param int    $requestsCompanyType        The type of the [Company][google.ads.admanager.v1.Company].
 */
function batch_update_companies_sample(
    string $formattedParent,
    string $requestsCompanyDisplayName,
    int $requestsCompanyType
): void {
    // Create a client.
    $companyServiceClient = new CompanyServiceClient();

    // Prepare the request message.
    $requestsCompany = (new Company())
        ->setDisplayName($requestsCompanyDisplayName)
        ->setType($requestsCompanyType);
    $updateCompanyRequest = (new UpdateCompanyRequest())
        ->setCompany($requestsCompany);
    $requests = [$updateCompanyRequest,];
    $request = (new BatchUpdateCompaniesRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateCompaniesResponse $response */
        $response = $companyServiceClient->batchUpdateCompanies($request);
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
    $formattedParent = CompanyServiceClient::networkName('[NETWORK_CODE]');
    $requestsCompanyDisplayName = '[DISPLAY_NAME]';
    $requestsCompanyType = CompanyType::COMPANY_TYPE_UNSPECIFIED;

    batch_update_companies_sample($formattedParent, $requestsCompanyDisplayName, $requestsCompanyType);
}
// [END admanager_v1_generated_CompanyService_BatchUpdateCompanies_sync]
