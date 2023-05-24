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

namespace Google\Cloud\Dataproc\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Dataproc\V1\AutoscalingPolicy;
use Google\Cloud\Dataproc\V1\BasicAutoscalingAlgorithm;
use Google\Cloud\Dataproc\V1\BasicYarnAutoscalingConfig;
use Google\Cloud\Dataproc\V1\Client\AutoscalingPolicyServiceClient;
use Google\Cloud\Dataproc\V1\CreateAutoscalingPolicyRequest;
use Google\Cloud\Dataproc\V1\DeleteAutoscalingPolicyRequest;
use Google\Cloud\Dataproc\V1\GetAutoscalingPolicyRequest;
use Google\Cloud\Dataproc\V1\InstanceGroupAutoscalingPolicyConfig;
use Google\Cloud\Dataproc\V1\ListAutoscalingPoliciesRequest;
use Google\Cloud\Dataproc\V1\ListAutoscalingPoliciesResponse;
use Google\Cloud\Dataproc\V1\UpdateAutoscalingPolicyRequest;
use Google\Protobuf\Duration;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group dataproc
 *
 * @group gapic
 */
class AutoscalingPolicyServiceClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
    }

    /** @return AutoscalingPolicyServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AutoscalingPolicyServiceClient($options);
    }

    /** @test */
    public function createAutoscalingPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $name = 'name3373707';
        $expectedResponse = new AutoscalingPolicy();
        $expectedResponse->setId($id);
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->regionName('[PROJECT]', '[REGION]');
        $policy = new AutoscalingPolicy();
        $policyWorkerConfig = new InstanceGroupAutoscalingPolicyConfig();
        $workerConfigMaxInstances = 339756550;
        $policyWorkerConfig->setMaxInstances($workerConfigMaxInstances);
        $policy->setWorkerConfig($policyWorkerConfig);
        $policyBasicAlgorithm = new BasicAutoscalingAlgorithm();
        $basicAlgorithmYarnConfig = new BasicYarnAutoscalingConfig();
        $yarnConfigGracefulDecommissionTimeout = new Duration();
        $basicAlgorithmYarnConfig->setGracefulDecommissionTimeout($yarnConfigGracefulDecommissionTimeout);
        $yarnConfigScaleUpFactor = -4.1551534E7;
        $basicAlgorithmYarnConfig->setScaleUpFactor($yarnConfigScaleUpFactor);
        $yarnConfigScaleDownFactor = -1.72221005E8;
        $basicAlgorithmYarnConfig->setScaleDownFactor($yarnConfigScaleDownFactor);
        $policyBasicAlgorithm->setYarnConfig($basicAlgorithmYarnConfig);
        $policy->setBasicAlgorithm($policyBasicAlgorithm);
        $request = (new CreateAutoscalingPolicyRequest())
            ->setParent($formattedParent)
            ->setPolicy($policy);
        $response = $gapicClient->createAutoscalingPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataproc.v1.AutoscalingPolicyService/CreateAutoscalingPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPolicy();
        $this->assertProtobufEquals($policy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAutoscalingPolicyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->regionName('[PROJECT]', '[REGION]');
        $policy = new AutoscalingPolicy();
        $policyWorkerConfig = new InstanceGroupAutoscalingPolicyConfig();
        $workerConfigMaxInstances = 339756550;
        $policyWorkerConfig->setMaxInstances($workerConfigMaxInstances);
        $policy->setWorkerConfig($policyWorkerConfig);
        $policyBasicAlgorithm = new BasicAutoscalingAlgorithm();
        $basicAlgorithmYarnConfig = new BasicYarnAutoscalingConfig();
        $yarnConfigGracefulDecommissionTimeout = new Duration();
        $basicAlgorithmYarnConfig->setGracefulDecommissionTimeout($yarnConfigGracefulDecommissionTimeout);
        $yarnConfigScaleUpFactor = -4.1551534E7;
        $basicAlgorithmYarnConfig->setScaleUpFactor($yarnConfigScaleUpFactor);
        $yarnConfigScaleDownFactor = -1.72221005E8;
        $basicAlgorithmYarnConfig->setScaleDownFactor($yarnConfigScaleDownFactor);
        $policyBasicAlgorithm->setYarnConfig($basicAlgorithmYarnConfig);
        $policy->setBasicAlgorithm($policyBasicAlgorithm);
        $request = (new CreateAutoscalingPolicyRequest())
            ->setParent($formattedParent)
            ->setPolicy($policy);
        try {
            $gapicClient->createAutoscalingPolicy($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAutoscalingPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->autoscalingPolicyName('[PROJECT]', '[LOCATION]', '[AUTOSCALING_POLICY]');
        $request = (new DeleteAutoscalingPolicyRequest())
            ->setName($formattedName);
        $gapicClient->deleteAutoscalingPolicy($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataproc.v1.AutoscalingPolicyService/DeleteAutoscalingPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAutoscalingPolicyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->autoscalingPolicyName('[PROJECT]', '[LOCATION]', '[AUTOSCALING_POLICY]');
        $request = (new DeleteAutoscalingPolicyRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteAutoscalingPolicy($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAutoscalingPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $name2 = 'name2-1052831874';
        $expectedResponse = new AutoscalingPolicy();
        $expectedResponse->setId($id);
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->autoscalingPolicyName('[PROJECT]', '[LOCATION]', '[AUTOSCALING_POLICY]');
        $request = (new GetAutoscalingPolicyRequest())
            ->setName($formattedName);
        $response = $gapicClient->getAutoscalingPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataproc.v1.AutoscalingPolicyService/GetAutoscalingPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAutoscalingPolicyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->autoscalingPolicyName('[PROJECT]', '[LOCATION]', '[AUTOSCALING_POLICY]');
        $request = (new GetAutoscalingPolicyRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getAutoscalingPolicy($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAutoscalingPoliciesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $policiesElement = new AutoscalingPolicy();
        $policies = [
            $policiesElement,
        ];
        $expectedResponse = new ListAutoscalingPoliciesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPolicies($policies);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->regionName('[PROJECT]', '[REGION]');
        $request = (new ListAutoscalingPoliciesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listAutoscalingPolicies($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPolicies()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataproc.v1.AutoscalingPolicyService/ListAutoscalingPolicies', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAutoscalingPoliciesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->regionName('[PROJECT]', '[REGION]');
        $request = (new ListAutoscalingPoliciesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listAutoscalingPolicies($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAutoscalingPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $name = 'name3373707';
        $expectedResponse = new AutoscalingPolicy();
        $expectedResponse->setId($id);
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $policy = new AutoscalingPolicy();
        $policyWorkerConfig = new InstanceGroupAutoscalingPolicyConfig();
        $workerConfigMaxInstances = 339756550;
        $policyWorkerConfig->setMaxInstances($workerConfigMaxInstances);
        $policy->setWorkerConfig($policyWorkerConfig);
        $policyBasicAlgorithm = new BasicAutoscalingAlgorithm();
        $basicAlgorithmYarnConfig = new BasicYarnAutoscalingConfig();
        $yarnConfigGracefulDecommissionTimeout = new Duration();
        $basicAlgorithmYarnConfig->setGracefulDecommissionTimeout($yarnConfigGracefulDecommissionTimeout);
        $yarnConfigScaleUpFactor = -4.1551534E7;
        $basicAlgorithmYarnConfig->setScaleUpFactor($yarnConfigScaleUpFactor);
        $yarnConfigScaleDownFactor = -1.72221005E8;
        $basicAlgorithmYarnConfig->setScaleDownFactor($yarnConfigScaleDownFactor);
        $policyBasicAlgorithm->setYarnConfig($basicAlgorithmYarnConfig);
        $policy->setBasicAlgorithm($policyBasicAlgorithm);
        $request = (new UpdateAutoscalingPolicyRequest())
            ->setPolicy($policy);
        $response = $gapicClient->updateAutoscalingPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataproc.v1.AutoscalingPolicyService/UpdateAutoscalingPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getPolicy();
        $this->assertProtobufEquals($policy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAutoscalingPolicyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $policy = new AutoscalingPolicy();
        $policyWorkerConfig = new InstanceGroupAutoscalingPolicyConfig();
        $workerConfigMaxInstances = 339756550;
        $policyWorkerConfig->setMaxInstances($workerConfigMaxInstances);
        $policy->setWorkerConfig($policyWorkerConfig);
        $policyBasicAlgorithm = new BasicAutoscalingAlgorithm();
        $basicAlgorithmYarnConfig = new BasicYarnAutoscalingConfig();
        $yarnConfigGracefulDecommissionTimeout = new Duration();
        $basicAlgorithmYarnConfig->setGracefulDecommissionTimeout($yarnConfigGracefulDecommissionTimeout);
        $yarnConfigScaleUpFactor = -4.1551534E7;
        $basicAlgorithmYarnConfig->setScaleUpFactor($yarnConfigScaleUpFactor);
        $yarnConfigScaleDownFactor = -1.72221005E8;
        $basicAlgorithmYarnConfig->setScaleDownFactor($yarnConfigScaleDownFactor);
        $policyBasicAlgorithm->setYarnConfig($basicAlgorithmYarnConfig);
        $policy->setBasicAlgorithm($policyBasicAlgorithm);
        $request = (new UpdateAutoscalingPolicyRequest())
            ->setPolicy($policy);
        try {
            $gapicClient->updateAutoscalingPolicy($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAutoscalingPolicyAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $name = 'name3373707';
        $expectedResponse = new AutoscalingPolicy();
        $expectedResponse->setId($id);
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->regionName('[PROJECT]', '[REGION]');
        $policy = new AutoscalingPolicy();
        $policyWorkerConfig = new InstanceGroupAutoscalingPolicyConfig();
        $workerConfigMaxInstances = 339756550;
        $policyWorkerConfig->setMaxInstances($workerConfigMaxInstances);
        $policy->setWorkerConfig($policyWorkerConfig);
        $policyBasicAlgorithm = new BasicAutoscalingAlgorithm();
        $basicAlgorithmYarnConfig = new BasicYarnAutoscalingConfig();
        $yarnConfigGracefulDecommissionTimeout = new Duration();
        $basicAlgorithmYarnConfig->setGracefulDecommissionTimeout($yarnConfigGracefulDecommissionTimeout);
        $yarnConfigScaleUpFactor = -4.1551534E7;
        $basicAlgorithmYarnConfig->setScaleUpFactor($yarnConfigScaleUpFactor);
        $yarnConfigScaleDownFactor = -1.72221005E8;
        $basicAlgorithmYarnConfig->setScaleDownFactor($yarnConfigScaleDownFactor);
        $policyBasicAlgorithm->setYarnConfig($basicAlgorithmYarnConfig);
        $policy->setBasicAlgorithm($policyBasicAlgorithm);
        $request = (new CreateAutoscalingPolicyRequest())
            ->setParent($formattedParent)
            ->setPolicy($policy);
        $response = $gapicClient->createAutoscalingPolicyAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataproc.v1.AutoscalingPolicyService/CreateAutoscalingPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPolicy();
        $this->assertProtobufEquals($policy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
