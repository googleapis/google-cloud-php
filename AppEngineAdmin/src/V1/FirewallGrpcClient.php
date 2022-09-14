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
namespace Google\Cloud\AppEngine\V1;

/**
 * Firewall resources are used to define a collection of access control rules
 * for an Application. Each rule is defined with a position which specifies
 * the rule's order in the sequence of rules, an IP range to be matched against
 * requests, and an action to take upon matching requests.
 *
 * Every request is evaluated against the Firewall rules in priority order.
 * Processesing stops at the first rule which matches the request's IP address.
 * A final rule always specifies an action that applies to all remaining
 * IP addresses. The default final rule for a newly-created application will be
 * set to "allow" if not otherwise specified by the user.
 */
class FirewallGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists the firewall rules of an application.
     * @param \Google\Cloud\AppEngine\V1\ListIngressRulesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListIngressRules(\Google\Cloud\AppEngine\V1\ListIngressRulesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Firewall/ListIngressRules',
        $argument,
        ['\Google\Cloud\AppEngine\V1\ListIngressRulesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Replaces the entire firewall ruleset in one bulk operation. This overrides
     * and replaces the rules of an existing firewall with the new rules.
     *
     * If the final rule does not match traffic with the '*' wildcard IP range,
     * then an "allow all" rule is explicitly added to the end of the list.
     * @param \Google\Cloud\AppEngine\V1\BatchUpdateIngressRulesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchUpdateIngressRules(\Google\Cloud\AppEngine\V1\BatchUpdateIngressRulesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Firewall/BatchUpdateIngressRules',
        $argument,
        ['\Google\Cloud\AppEngine\V1\BatchUpdateIngressRulesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a firewall rule for the application.
     * @param \Google\Cloud\AppEngine\V1\CreateIngressRuleRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateIngressRule(\Google\Cloud\AppEngine\V1\CreateIngressRuleRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Firewall/CreateIngressRule',
        $argument,
        ['\Google\Cloud\AppEngine\V1\FirewallRule', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the specified firewall rule.
     * @param \Google\Cloud\AppEngine\V1\GetIngressRuleRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIngressRule(\Google\Cloud\AppEngine\V1\GetIngressRuleRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Firewall/GetIngressRule',
        $argument,
        ['\Google\Cloud\AppEngine\V1\FirewallRule', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified firewall rule.
     * @param \Google\Cloud\AppEngine\V1\UpdateIngressRuleRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateIngressRule(\Google\Cloud\AppEngine\V1\UpdateIngressRuleRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Firewall/UpdateIngressRule',
        $argument,
        ['\Google\Cloud\AppEngine\V1\FirewallRule', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified firewall rule.
     * @param \Google\Cloud\AppEngine\V1\DeleteIngressRuleRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteIngressRule(\Google\Cloud\AppEngine\V1\DeleteIngressRuleRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Firewall/DeleteIngressRule',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
