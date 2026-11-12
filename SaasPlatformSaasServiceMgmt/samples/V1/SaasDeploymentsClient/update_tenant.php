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

// [START saasservicemgmt_v1_generated_SaasDeployments_UpdateTenant_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\Client\SaasDeploymentsClient;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\Tenant;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\UpdateTenantRequest;

/**
 * Update a single tenant.
 *
 * @param string $formattedTenantSaas Immutable. A reference to the Saas that defines the product
 *                                    (managed service) that the producer wants to manage with App Lifecycle
 *                                    Manager. Part of the App Lifecycle Manager common data model. Please see
 *                                    {@see SaasDeploymentsClient::saasName()} for help formatting this field.
 */
function update_tenant_sample(string $formattedTenantSaas): void
{
    // Create a client.
    $saasDeploymentsClient = new SaasDeploymentsClient();

    // Prepare the request message.
    $tenant = (new Tenant())
        ->setSaas($formattedTenantSaas);
    $request = (new UpdateTenantRequest())
        ->setTenant($tenant);

    // Call the API and handle any network failures.
    try {
        /** @var Tenant $response */
        $response = $saasDeploymentsClient->updateTenant($request);
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
    $formattedTenantSaas = SaasDeploymentsClient::saasName('[PROJECT]', '[LOCATION]', '[SAAS]');

    update_tenant_sample($formattedTenantSaas);
}
// [END saasservicemgmt_v1_generated_SaasDeployments_UpdateTenant_sync]
