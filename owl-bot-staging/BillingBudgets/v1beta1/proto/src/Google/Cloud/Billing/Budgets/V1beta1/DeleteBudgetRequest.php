<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/billing/budgets/v1beta1/budget_service.proto

namespace Google\Cloud\Billing\Budgets\V1beta1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request for DeleteBudget
 *
 * Generated from protobuf message <code>google.cloud.billing.budgets.v1beta1.DeleteBudgetRequest</code>
 */
class DeleteBudgetRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Name of the budget to delete. Values are of the form
     * `billingAccounts/{billingAccountId}/budgets/{budgetId}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. Name of the budget to delete. Values are of the form
     *           `billingAccounts/{billingAccountId}/budgets/{budgetId}`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Billing\Budgets\V1Beta1\BudgetService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Name of the budget to delete. Values are of the form
     * `billingAccounts/{billingAccountId}/budgets/{budgetId}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. Name of the budget to delete. Values are of the form
     * `billingAccounts/{billingAccountId}/budgets/{budgetId}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

}
