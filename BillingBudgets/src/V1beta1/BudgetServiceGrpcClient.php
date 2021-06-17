<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\Billing\Budgets\V1beta1;

/**
 * BudgetService stores Cloud Billing budgets, which define a
 * budget plan and rules to execute as we track spend against that plan.
 */
class BudgetServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new budget. See
     * <a href="https://cloud.google.com/billing/quotas">Quotas and limits</a>
     * for more information on the limits of the number of budgets you can create.
     * @param \Google\Cloud\Billing\Budgets\V1beta1\CreateBudgetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBudget(\Google\Cloud\Billing\Budgets\V1beta1\CreateBudgetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.budgets.v1beta1.BudgetService/CreateBudget',
        $argument,
        ['\Google\Cloud\Billing\Budgets\V1beta1\Budget', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a budget and returns the updated budget.
     *
     * WARNING: There are some fields exposed on the Google Cloud Console that
     * aren't available on this API. Budget fields that are not exposed in
     * this API will not be changed by this method.
     * @param \Google\Cloud\Billing\Budgets\V1beta1\UpdateBudgetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateBudget(\Google\Cloud\Billing\Budgets\V1beta1\UpdateBudgetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.budgets.v1beta1.BudgetService/UpdateBudget',
        $argument,
        ['\Google\Cloud\Billing\Budgets\V1beta1\Budget', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a budget.
     *
     * WARNING: There are some fields exposed on the Google Cloud Console that
     * aren't available on this API. When reading from the API, you will not
     * see these fields in the return value, though they may have been set
     * in the Cloud Console.
     * @param \Google\Cloud\Billing\Budgets\V1beta1\GetBudgetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBudget(\Google\Cloud\Billing\Budgets\V1beta1\GetBudgetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.budgets.v1beta1.BudgetService/GetBudget',
        $argument,
        ['\Google\Cloud\Billing\Budgets\V1beta1\Budget', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of budgets for a billing account.
     *
     * WARNING: There are some fields exposed on the Google Cloud Console that
     * aren't available on this API. When reading from the API, you will not
     * see these fields in the return value, though they may have been set
     * in the Cloud Console.
     * @param \Google\Cloud\Billing\Budgets\V1beta1\ListBudgetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBudgets(\Google\Cloud\Billing\Budgets\V1beta1\ListBudgetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.budgets.v1beta1.BudgetService/ListBudgets',
        $argument,
        ['\Google\Cloud\Billing\Budgets\V1beta1\ListBudgetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a budget. Returns successfully if already deleted.
     * @param \Google\Cloud\Billing\Budgets\V1beta1\DeleteBudgetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBudget(\Google\Cloud\Billing\Budgets\V1beta1\DeleteBudgetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.budgets.v1beta1.BudgetService/DeleteBudget',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
