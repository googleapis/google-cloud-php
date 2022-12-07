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

// [START billingbudgets_v1_generated_BudgetService_UpdateBudget_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Billing\Budgets\V1\Budget;
use Google\Cloud\Billing\Budgets\V1\BudgetAmount;
use Google\Cloud\Billing\Budgets\V1\BudgetServiceClient;

/**
 * Updates a budget and returns the updated budget.
 *
 * WARNING: There are some fields exposed on the Google Cloud Console that
 * aren't available on this API. Budget fields that are not exposed in
 * this API will not be changed by this method.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_budget_sample(): void
{
    // Create a client.
    $budgetServiceClient = new BudgetServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $budgetAmount = new BudgetAmount();
    $budget = (new Budget())
        ->setAmount($budgetAmount);

    // Call the API and handle any network failures.
    try {
        /** @var Budget $response */
        $response = $budgetServiceClient->updateBudget($budget);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END billingbudgets_v1_generated_BudgetService_UpdateBudget_sync]
