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

// [START billingbudgets_v1_generated_BudgetService_CreateBudget_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Billing\Budgets\V1\Budget;
use Google\Cloud\Billing\Budgets\V1\BudgetAmount;
use Google\Cloud\Billing\Budgets\V1\BudgetServiceClient;

/**
 * Creates a new budget. See
 * [Quotas and limits](https://cloud.google.com/billing/quotas)
 * for more information on the limits of the number of budgets you can create.
 *
 * @param string $formattedParent The name of the billing account to create the budget in. Values
 *                                are of the form `billingAccounts/{billingAccountId}`. Please see
 *                                {@see BudgetServiceClient::billingAccountName()} for help formatting this field.
 */
function create_budget_sample(string $formattedParent): void
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
        $response = $budgetServiceClient->createBudget($formattedParent, $budget);
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
    $formattedParent = BudgetServiceClient::billingAccountName('[BILLING_ACCOUNT]');

    create_budget_sample($formattedParent);
}
// [END billingbudgets_v1_generated_BudgetService_CreateBudget_sync]
