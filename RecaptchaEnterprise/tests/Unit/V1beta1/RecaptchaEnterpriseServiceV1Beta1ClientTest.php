<?php
/*
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\RecaptchaEnterprise\Tests\Unit\V1beta1;

use Google\Cloud\RecaptchaEnterprise\V1beta1\RecaptchaEnterpriseServiceV1Beta1Client;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\RecaptchaEnterprise\V1beta1\AnnotateAssessmentRequest_Annotation;
use Google\Cloud\RecaptchaEnterprise\V1beta1\AnnotateAssessmentResponse;
use Google\Cloud\RecaptchaEnterprise\V1beta1\Assessment;
use Google\Protobuf\Any;
use Google\Rpc\Code;
use stdClass;

/**
 * @group recaptchaenterprise
 * @group gapic
 */
class RecaptchaEnterpriseServiceV1Beta1ClientTest extends GeneratedTest
{
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return RecaptchaEnterpriseServiceV1Beta1Client
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->getMockBuilder(CredentialsWrapper::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        return new RecaptchaEnterpriseServiceV1Beta1Client($options);
    }

    /**
     * @test
     */
    public function createAssessmentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $score = 1.0926453E7;
        $expectedResponse = new Assessment();
        $expectedResponse->setName($name);
        $expectedResponse->setScore($score);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');
        $assessment = new Assessment();

        $response = $client->createAssessment($formattedParent, $assessment);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recaptchaenterprise.v1beta1.RecaptchaEnterpriseServiceV1Beta1/CreateAssessment', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAssessment();

        $this->assertProtobufEquals($assessment, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createAssessmentExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');
        $assessment = new Assessment();

        try {
            $client->createAssessment($formattedParent, $assessment);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }

        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function annotateAssessmentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new AnnotateAssessmentResponse();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->assessmentName('[PROJECT]', '[ASSESSMENT]');
        $annotation = AnnotateAssessmentRequest_Annotation::ANNOTATION_UNSPECIFIED;

        $response = $client->annotateAssessment($formattedName, $annotation);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recaptchaenterprise.v1beta1.RecaptchaEnterpriseServiceV1Beta1/AnnotateAssessment', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getAnnotation();

        $this->assertProtobufEquals($annotation, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function annotateAssessmentExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $formattedName = $client->assessmentName('[PROJECT]', '[ASSESSMENT]');
        $annotation = AnnotateAssessmentRequest_Annotation::ANNOTATION_UNSPECIFIED;

        try {
            $client->annotateAssessment($formattedName, $annotation);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }

        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }
}
