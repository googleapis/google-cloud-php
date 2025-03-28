<?php
/*
 * Copyright 2025 Google LLC
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

namespace Google\Cloud\RecaptchaEnterprise\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\RecaptchaEnterprise\V1\AddIpOverrideRequest;
use Google\Cloud\RecaptchaEnterprise\V1\AddIpOverrideResponse;
use Google\Cloud\RecaptchaEnterprise\V1\AnnotateAssessmentRequest;
use Google\Cloud\RecaptchaEnterprise\V1\AnnotateAssessmentRequest\Annotation;
use Google\Cloud\RecaptchaEnterprise\V1\AnnotateAssessmentResponse;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\CreateAssessmentRequest;
use Google\Cloud\RecaptchaEnterprise\V1\CreateFirewallPolicyRequest;
use Google\Cloud\RecaptchaEnterprise\V1\CreateKeyRequest;
use Google\Cloud\RecaptchaEnterprise\V1\DeleteFirewallPolicyRequest;
use Google\Cloud\RecaptchaEnterprise\V1\DeleteKeyRequest;
use Google\Cloud\RecaptchaEnterprise\V1\FirewallPolicy;
use Google\Cloud\RecaptchaEnterprise\V1\GetFirewallPolicyRequest;
use Google\Cloud\RecaptchaEnterprise\V1\GetKeyRequest;
use Google\Cloud\RecaptchaEnterprise\V1\GetMetricsRequest;
use Google\Cloud\RecaptchaEnterprise\V1\IpOverrideData;
use Google\Cloud\RecaptchaEnterprise\V1\IpOverrideData\OverrideType;
use Google\Cloud\RecaptchaEnterprise\V1\Key;
use Google\Cloud\RecaptchaEnterprise\V1\ListFirewallPoliciesRequest;
use Google\Cloud\RecaptchaEnterprise\V1\ListFirewallPoliciesResponse;
use Google\Cloud\RecaptchaEnterprise\V1\ListIpOverridesRequest;
use Google\Cloud\RecaptchaEnterprise\V1\ListIpOverridesResponse;
use Google\Cloud\RecaptchaEnterprise\V1\ListKeysRequest;
use Google\Cloud\RecaptchaEnterprise\V1\ListKeysResponse;
use Google\Cloud\RecaptchaEnterprise\V1\ListRelatedAccountGroupMembershipsRequest;
use Google\Cloud\RecaptchaEnterprise\V1\ListRelatedAccountGroupMembershipsResponse;
use Google\Cloud\RecaptchaEnterprise\V1\ListRelatedAccountGroupsRequest;
use Google\Cloud\RecaptchaEnterprise\V1\ListRelatedAccountGroupsResponse;
use Google\Cloud\RecaptchaEnterprise\V1\Metrics;
use Google\Cloud\RecaptchaEnterprise\V1\MigrateKeyRequest;
use Google\Cloud\RecaptchaEnterprise\V1\RelatedAccountGroup;
use Google\Cloud\RecaptchaEnterprise\V1\RelatedAccountGroupMembership;
use Google\Cloud\RecaptchaEnterprise\V1\RemoveIpOverrideRequest;
use Google\Cloud\RecaptchaEnterprise\V1\RemoveIpOverrideResponse;
use Google\Cloud\RecaptchaEnterprise\V1\ReorderFirewallPoliciesRequest;
use Google\Cloud\RecaptchaEnterprise\V1\ReorderFirewallPoliciesResponse;
use Google\Cloud\RecaptchaEnterprise\V1\RetrieveLegacySecretKeyRequest;
use Google\Cloud\RecaptchaEnterprise\V1\RetrieveLegacySecretKeyResponse;
use Google\Cloud\RecaptchaEnterprise\V1\SearchRelatedAccountGroupMembershipsRequest;
use Google\Cloud\RecaptchaEnterprise\V1\SearchRelatedAccountGroupMembershipsResponse;
use Google\Cloud\RecaptchaEnterprise\V1\UpdateFirewallPolicyRequest;
use Google\Cloud\RecaptchaEnterprise\V1\UpdateKeyRequest;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group recaptchaenterprise
 *
 * @group gapic
 */
class RecaptchaEnterpriseServiceClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /** @return RecaptchaEnterpriseServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new RecaptchaEnterpriseServiceClient($options);
    }

    /** @test */
    public function addIpOverrideTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new AddIpOverrideResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $ipOverrideData = new IpOverrideData();
        $ipOverrideDataIp = 'ipOverrideDataIp1421737572';
        $ipOverrideData->setIp($ipOverrideDataIp);
        $ipOverrideDataOverrideType = OverrideType::OVERRIDE_TYPE_UNSPECIFIED;
        $ipOverrideData->setOverrideType($ipOverrideDataOverrideType);
        $request = (new AddIpOverrideRequest())->setName($formattedName)->setIpOverrideData($ipOverrideData);
        $response = $gapicClient->addIpOverride($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/AddIpOverride',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getIpOverrideData();
        $this->assertProtobufEquals($ipOverrideData, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function addIpOverrideExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $ipOverrideData = new IpOverrideData();
        $ipOverrideDataIp = 'ipOverrideDataIp1421737572';
        $ipOverrideData->setIp($ipOverrideDataIp);
        $ipOverrideDataOverrideType = OverrideType::OVERRIDE_TYPE_UNSPECIFIED;
        $ipOverrideData->setOverrideType($ipOverrideDataOverrideType);
        $request = (new AddIpOverrideRequest())->setName($formattedName)->setIpOverrideData($ipOverrideData);
        try {
            $gapicClient->addIpOverride($request);
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
    public function annotateAssessmentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new AnnotateAssessmentResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->assessmentName('[PROJECT]', '[ASSESSMENT]');
        $annotation = Annotation::ANNOTATION_UNSPECIFIED;
        $request = (new AnnotateAssessmentRequest())->setName($formattedName)->setAnnotation($annotation);
        $response = $gapicClient->annotateAssessment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/AnnotateAssessment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getAnnotation();
        $this->assertProtobufEquals($annotation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function annotateAssessmentExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->assessmentName('[PROJECT]', '[ASSESSMENT]');
        $annotation = Annotation::ANNOTATION_UNSPECIFIED;
        $request = (new AnnotateAssessmentRequest())->setName($formattedName)->setAnnotation($annotation);
        try {
            $gapicClient->annotateAssessment($request);
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
    public function createAssessmentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new Assessment();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $assessment = new Assessment();
        $request = (new CreateAssessmentRequest())->setParent($formattedParent)->setAssessment($assessment);
        $response = $gapicClient->createAssessment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/CreateAssessment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAssessment();
        $this->assertProtobufEquals($assessment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAssessmentExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $assessment = new Assessment();
        $request = (new CreateAssessmentRequest())->setParent($formattedParent)->setAssessment($assessment);
        try {
            $gapicClient->createAssessment($request);
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
    public function createFirewallPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $path = 'path3433509';
        $condition = 'condition-861311717';
        $expectedResponse = new FirewallPolicy();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setPath($path);
        $expectedResponse->setCondition($condition);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $firewallPolicy = new FirewallPolicy();
        $request = (new CreateFirewallPolicyRequest())->setParent($formattedParent)->setFirewallPolicy($firewallPolicy);
        $response = $gapicClient->createFirewallPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/CreateFirewallPolicy',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getFirewallPolicy();
        $this->assertProtobufEquals($firewallPolicy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createFirewallPolicyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $firewallPolicy = new FirewallPolicy();
        $request = (new CreateFirewallPolicyRequest())->setParent($formattedParent)->setFirewallPolicy($firewallPolicy);
        try {
            $gapicClient->createFirewallPolicy($request);
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
    public function createKeyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Key();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $key = new Key();
        $keyDisplayName = 'keyDisplayName-302940530';
        $key->setDisplayName($keyDisplayName);
        $request = (new CreateKeyRequest())->setParent($formattedParent)->setKey($key);
        $response = $gapicClient->createKey($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/CreateKey', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getKey();
        $this->assertProtobufEquals($key, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createKeyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $key = new Key();
        $keyDisplayName = 'keyDisplayName-302940530';
        $key->setDisplayName($keyDisplayName);
        $request = (new CreateKeyRequest())->setParent($formattedParent)->setKey($key);
        try {
            $gapicClient->createKey($request);
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
    public function deleteFirewallPolicyTest()
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
        $formattedName = $gapicClient->firewallPolicyName('[PROJECT]', '[FIREWALLPOLICY]');
        $request = (new DeleteFirewallPolicyRequest())->setName($formattedName);
        $gapicClient->deleteFirewallPolicy($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/DeleteFirewallPolicy',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteFirewallPolicyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->firewallPolicyName('[PROJECT]', '[FIREWALLPOLICY]');
        $request = (new DeleteFirewallPolicyRequest())->setName($formattedName);
        try {
            $gapicClient->deleteFirewallPolicy($request);
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
    public function deleteKeyTest()
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
        $formattedName = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $request = (new DeleteKeyRequest())->setName($formattedName);
        $gapicClient->deleteKey($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/DeleteKey', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteKeyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $request = (new DeleteKeyRequest())->setName($formattedName);
        try {
            $gapicClient->deleteKey($request);
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
    public function getFirewallPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $path = 'path3433509';
        $condition = 'condition-861311717';
        $expectedResponse = new FirewallPolicy();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setPath($path);
        $expectedResponse->setCondition($condition);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->firewallPolicyName('[PROJECT]', '[FIREWALLPOLICY]');
        $request = (new GetFirewallPolicyRequest())->setName($formattedName);
        $response = $gapicClient->getFirewallPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/GetFirewallPolicy',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getFirewallPolicyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->firewallPolicyName('[PROJECT]', '[FIREWALLPOLICY]');
        $request = (new GetFirewallPolicyRequest())->setName($formattedName);
        try {
            $gapicClient->getFirewallPolicy($request);
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
    public function getKeyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Key();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $request = (new GetKeyRequest())->setName($formattedName);
        $response = $gapicClient->getKey($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/GetKey', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getKeyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $request = (new GetKeyRequest())->setName($formattedName);
        try {
            $gapicClient->getKey($request);
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
    public function getMetricsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new Metrics();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->metricsName('[PROJECT]', '[KEY]');
        $request = (new GetMetricsRequest())->setName($formattedName);
        $response = $gapicClient->getMetrics($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/GetMetrics',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getMetricsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->metricsName('[PROJECT]', '[KEY]');
        $request = (new GetMetricsRequest())->setName($formattedName);
        try {
            $gapicClient->getMetrics($request);
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
    public function listFirewallPoliciesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $firewallPoliciesElement = new FirewallPolicy();
        $firewallPolicies = [$firewallPoliciesElement];
        $expectedResponse = new ListFirewallPoliciesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setFirewallPolicies($firewallPolicies);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListFirewallPoliciesRequest())->setParent($formattedParent);
        $response = $gapicClient->listFirewallPolicies($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getFirewallPolicies()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/ListFirewallPolicies',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listFirewallPoliciesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListFirewallPoliciesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listFirewallPolicies($request);
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
    public function listIpOverridesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $ipOverridesElement = new IpOverrideData();
        $ipOverrides = [$ipOverridesElement];
        $expectedResponse = new ListIpOverridesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setIpOverrides($ipOverrides);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $request = (new ListIpOverridesRequest())->setParent($formattedParent);
        $response = $gapicClient->listIpOverrides($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getIpOverrides()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/ListIpOverrides',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listIpOverridesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $request = (new ListIpOverridesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listIpOverrides($request);
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
    public function listKeysTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $keysElement = new Key();
        $keys = [$keysElement];
        $expectedResponse = new ListKeysResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setKeys($keys);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListKeysRequest())->setParent($formattedParent);
        $response = $gapicClient->listKeys($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getKeys()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/ListKeys', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listKeysExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListKeysRequest())->setParent($formattedParent);
        try {
            $gapicClient->listKeys($request);
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
    public function listRelatedAccountGroupMembershipsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $relatedAccountGroupMembershipsElement = new RelatedAccountGroupMembership();
        $relatedAccountGroupMemberships = [$relatedAccountGroupMembershipsElement];
        $expectedResponse = new ListRelatedAccountGroupMembershipsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setRelatedAccountGroupMemberships($relatedAccountGroupMemberships);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->relatedAccountGroupName('[PROJECT]', '[RELATEDACCOUNTGROUP]');
        $request = (new ListRelatedAccountGroupMembershipsRequest())->setParent($formattedParent);
        $response = $gapicClient->listRelatedAccountGroupMemberships($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRelatedAccountGroupMemberships()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/ListRelatedAccountGroupMemberships',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listRelatedAccountGroupMembershipsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->relatedAccountGroupName('[PROJECT]', '[RELATEDACCOUNTGROUP]');
        $request = (new ListRelatedAccountGroupMembershipsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listRelatedAccountGroupMemberships($request);
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
    public function listRelatedAccountGroupsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $relatedAccountGroupsElement = new RelatedAccountGroup();
        $relatedAccountGroups = [$relatedAccountGroupsElement];
        $expectedResponse = new ListRelatedAccountGroupsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setRelatedAccountGroups($relatedAccountGroups);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListRelatedAccountGroupsRequest())->setParent($formattedParent);
        $response = $gapicClient->listRelatedAccountGroups($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRelatedAccountGroups()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/ListRelatedAccountGroups',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listRelatedAccountGroupsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListRelatedAccountGroupsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listRelatedAccountGroups($request);
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
    public function migrateKeyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Key();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $request = (new MigrateKeyRequest())->setName($formattedName);
        $response = $gapicClient->migrateKey($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/MigrateKey',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function migrateKeyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $request = (new MigrateKeyRequest())->setName($formattedName);
        try {
            $gapicClient->migrateKey($request);
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
    public function removeIpOverrideTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RemoveIpOverrideResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $ipOverrideData = new IpOverrideData();
        $ipOverrideDataIp = 'ipOverrideDataIp1421737572';
        $ipOverrideData->setIp($ipOverrideDataIp);
        $ipOverrideDataOverrideType = OverrideType::OVERRIDE_TYPE_UNSPECIFIED;
        $ipOverrideData->setOverrideType($ipOverrideDataOverrideType);
        $request = (new RemoveIpOverrideRequest())->setName($formattedName)->setIpOverrideData($ipOverrideData);
        $response = $gapicClient->removeIpOverride($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/RemoveIpOverride',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getIpOverrideData();
        $this->assertProtobufEquals($ipOverrideData, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function removeIpOverrideExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $ipOverrideData = new IpOverrideData();
        $ipOverrideDataIp = 'ipOverrideDataIp1421737572';
        $ipOverrideData->setIp($ipOverrideDataIp);
        $ipOverrideDataOverrideType = OverrideType::OVERRIDE_TYPE_UNSPECIFIED;
        $ipOverrideData->setOverrideType($ipOverrideDataOverrideType);
        $request = (new RemoveIpOverrideRequest())->setName($formattedName)->setIpOverrideData($ipOverrideData);
        try {
            $gapicClient->removeIpOverride($request);
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
    public function reorderFirewallPoliciesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ReorderFirewallPoliciesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $formattedNames = [$gapicClient->firewallPolicyName('[PROJECT]', '[FIREWALLPOLICY]')];
        $request = (new ReorderFirewallPoliciesRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->reorderFirewallPolicies($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/ReorderFirewallPolicies',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function reorderFirewallPoliciesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $formattedNames = [$gapicClient->firewallPolicyName('[PROJECT]', '[FIREWALLPOLICY]')];
        $request = (new ReorderFirewallPoliciesRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->reorderFirewallPolicies($request);
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
    public function retrieveLegacySecretKeyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $legacySecretKey = 'legacySecretKey-1937138042';
        $expectedResponse = new RetrieveLegacySecretKeyResponse();
        $expectedResponse->setLegacySecretKey($legacySecretKey);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedKey = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $request = (new RetrieveLegacySecretKeyRequest())->setKey($formattedKey);
        $response = $gapicClient->retrieveLegacySecretKey($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/RetrieveLegacySecretKey',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getKey();
        $this->assertProtobufEquals($formattedKey, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function retrieveLegacySecretKeyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedKey = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $request = (new RetrieveLegacySecretKeyRequest())->setKey($formattedKey);
        try {
            $gapicClient->retrieveLegacySecretKey($request);
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
    public function searchRelatedAccountGroupMembershipsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $relatedAccountGroupMembershipsElement = new RelatedAccountGroupMembership();
        $relatedAccountGroupMemberships = [$relatedAccountGroupMembershipsElement];
        $expectedResponse = new SearchRelatedAccountGroupMembershipsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setRelatedAccountGroupMemberships($relatedAccountGroupMemberships);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedProject = $gapicClient->projectName('[PROJECT]');
        $request = (new SearchRelatedAccountGroupMembershipsRequest())->setProject($formattedProject);
        $response = $gapicClient->searchRelatedAccountGroupMemberships($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRelatedAccountGroupMemberships()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/SearchRelatedAccountGroupMemberships',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($formattedProject, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchRelatedAccountGroupMembershipsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedProject = $gapicClient->projectName('[PROJECT]');
        $request = (new SearchRelatedAccountGroupMembershipsRequest())->setProject($formattedProject);
        try {
            $gapicClient->searchRelatedAccountGroupMemberships($request);
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
    public function updateFirewallPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $path = 'path3433509';
        $condition = 'condition-861311717';
        $expectedResponse = new FirewallPolicy();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setPath($path);
        $expectedResponse->setCondition($condition);
        $transport->addResponse($expectedResponse);
        // Mock request
        $firewallPolicy = new FirewallPolicy();
        $request = (new UpdateFirewallPolicyRequest())->setFirewallPolicy($firewallPolicy);
        $response = $gapicClient->updateFirewallPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/UpdateFirewallPolicy',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getFirewallPolicy();
        $this->assertProtobufEquals($firewallPolicy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateFirewallPolicyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $firewallPolicy = new FirewallPolicy();
        $request = (new UpdateFirewallPolicyRequest())->setFirewallPolicy($firewallPolicy);
        try {
            $gapicClient->updateFirewallPolicy($request);
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
    public function updateKeyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Key();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $key = new Key();
        $keyDisplayName = 'keyDisplayName-302940530';
        $key->setDisplayName($keyDisplayName);
        $request = (new UpdateKeyRequest())->setKey($key);
        $response = $gapicClient->updateKey($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/UpdateKey', $actualFuncCall);
        $actualValue = $actualRequestObject->getKey();
        $this->assertProtobufEquals($key, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateKeyExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $key = new Key();
        $keyDisplayName = 'keyDisplayName-302940530';
        $key->setDisplayName($keyDisplayName);
        $request = (new UpdateKeyRequest())->setKey($key);
        try {
            $gapicClient->updateKey($request);
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
    public function addIpOverrideAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new AddIpOverrideResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->keyName('[PROJECT]', '[KEY]');
        $ipOverrideData = new IpOverrideData();
        $ipOverrideDataIp = 'ipOverrideDataIp1421737572';
        $ipOverrideData->setIp($ipOverrideDataIp);
        $ipOverrideDataOverrideType = OverrideType::OVERRIDE_TYPE_UNSPECIFIED;
        $ipOverrideData->setOverrideType($ipOverrideDataOverrideType);
        $request = (new AddIpOverrideRequest())->setName($formattedName)->setIpOverrideData($ipOverrideData);
        $response = $gapicClient->addIpOverrideAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/AddIpOverride',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getIpOverrideData();
        $this->assertProtobufEquals($ipOverrideData, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
