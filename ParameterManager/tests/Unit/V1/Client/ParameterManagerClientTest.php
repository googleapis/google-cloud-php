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

namespace Google\Cloud\ParameterManager\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Cloud\ParameterManager\V1\Client\ParameterManagerClient;
use Google\Cloud\ParameterManager\V1\CreateParameterRequest;
use Google\Cloud\ParameterManager\V1\CreateParameterVersionRequest;
use Google\Cloud\ParameterManager\V1\CreateTemplateRequest;
use Google\Cloud\ParameterManager\V1\CreateTemplateVersionRequest;
use Google\Cloud\ParameterManager\V1\DeleteParameterRequest;
use Google\Cloud\ParameterManager\V1\DeleteParameterVersionRequest;
use Google\Cloud\ParameterManager\V1\DeleteTemplateRequest;
use Google\Cloud\ParameterManager\V1\DeleteTemplateVersionRequest;
use Google\Cloud\ParameterManager\V1\GetParameterRequest;
use Google\Cloud\ParameterManager\V1\GetParameterVersionRequest;
use Google\Cloud\ParameterManager\V1\GetTemplateRequest;
use Google\Cloud\ParameterManager\V1\GetTemplateVersionRequest;
use Google\Cloud\ParameterManager\V1\ListParameterVersionsRequest;
use Google\Cloud\ParameterManager\V1\ListParameterVersionsResponse;
use Google\Cloud\ParameterManager\V1\ListParametersRequest;
use Google\Cloud\ParameterManager\V1\ListParametersResponse;
use Google\Cloud\ParameterManager\V1\ListTemplateVersionsRequest;
use Google\Cloud\ParameterManager\V1\ListTemplateVersionsResponse;
use Google\Cloud\ParameterManager\V1\ListTemplatesRequest;
use Google\Cloud\ParameterManager\V1\ListTemplatesResponse;
use Google\Cloud\ParameterManager\V1\Parameter;
use Google\Cloud\ParameterManager\V1\ParameterVersion;
use Google\Cloud\ParameterManager\V1\ParameterVersionPayload;
use Google\Cloud\ParameterManager\V1\RenderParameterVersionRequest;
use Google\Cloud\ParameterManager\V1\RenderParameterVersionResponse;
use Google\Cloud\ParameterManager\V1\RenderTemplateVersionRequest;
use Google\Cloud\ParameterManager\V1\RenderTemplateVersionResponse;
use Google\Cloud\ParameterManager\V1\Template;
use Google\Cloud\ParameterManager\V1\TemplateVersion;
use Google\Cloud\ParameterManager\V1\TemplateVersionPayload;
use Google\Cloud\ParameterManager\V1\UpdateParameterRequest;
use Google\Cloud\ParameterManager\V1\UpdateParameterVersionRequest;
use Google\Cloud\ParameterManager\V1\UpdateTemplateRequest;
use Google\Cloud\ParameterManager\V1\UpdateTemplateVersionRequest;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group parametermanager
 *
 * @group gapic
 */
class ParameterManagerClientTest extends GeneratedTest
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

    /** @return ParameterManagerClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ParameterManagerClient($options);
    }

    /** @test */
    public function createParameterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $kmsKey = 'kmsKey-591635343';
        $expectedResponse = new Parameter();
        $expectedResponse->setName($name);
        $expectedResponse->setKmsKey($kmsKey);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $parameterId = 'parameterId-1536249487';
        $parameter = new Parameter();
        $request = (new CreateParameterRequest())
            ->setParent($formattedParent)
            ->setParameterId($parameterId)
            ->setParameter($parameter);
        $response = $gapicClient->createParameter($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/CreateParameter', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getParameterId();
        $this->assertProtobufEquals($parameterId, $actualValue);
        $actualValue = $actualRequestObject->getParameter();
        $this->assertProtobufEquals($parameter, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createParameterExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $parameterId = 'parameterId-1536249487';
        $parameter = new Parameter();
        $request = (new CreateParameterRequest())
            ->setParent($formattedParent)
            ->setParameterId($parameterId)
            ->setParameter($parameter);
        try {
            $gapicClient->createParameter($request);
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
    public function createParameterVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $disabled = true;
        $kmsKeyVersion = 'kmsKeyVersion207232778';
        $expectedResponse = new ParameterVersion();
        $expectedResponse->setName($name);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setKmsKeyVersion($kmsKeyVersion);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->parameterName('[PROJECT]', '[LOCATION]', '[PARAMETER]');
        $parameterVersionId = 'parameterVersionId-728697800';
        $parameterVersion = new ParameterVersion();
        $parameterVersionPayload = new ParameterVersionPayload();
        $payloadData = '88';
        $parameterVersionPayload->setData($payloadData);
        $parameterVersion->setPayload($parameterVersionPayload);
        $request = (new CreateParameterVersionRequest())
            ->setParent($formattedParent)
            ->setParameterVersionId($parameterVersionId)
            ->setParameterVersion($parameterVersion);
        $response = $gapicClient->createParameterVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/CreateParameterVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getParameterVersionId();
        $this->assertProtobufEquals($parameterVersionId, $actualValue);
        $actualValue = $actualRequestObject->getParameterVersion();
        $this->assertProtobufEquals($parameterVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createParameterVersionExceptionTest()
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
        $formattedParent = $gapicClient->parameterName('[PROJECT]', '[LOCATION]', '[PARAMETER]');
        $parameterVersionId = 'parameterVersionId-728697800';
        $parameterVersion = new ParameterVersion();
        $parameterVersionPayload = new ParameterVersionPayload();
        $payloadData = '88';
        $parameterVersionPayload->setData($payloadData);
        $parameterVersion->setPayload($parameterVersionPayload);
        $request = (new CreateParameterVersionRequest())
            ->setParent($formattedParent)
            ->setParameterVersionId($parameterVersionId)
            ->setParameterVersion($parameterVersion);
        try {
            $gapicClient->createParameterVersion($request);
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
    public function createTemplateTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new Template();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $templateId = 'templateId1769642752';
        $template = new Template();
        $request = (new CreateTemplateRequest())
            ->setParent($formattedParent)
            ->setTemplateId($templateId)
            ->setTemplate($template);
        $response = $gapicClient->createTemplate($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/CreateTemplate', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTemplateId();
        $this->assertProtobufEquals($templateId, $actualValue);
        $actualValue = $actualRequestObject->getTemplate();
        $this->assertProtobufEquals($template, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createTemplateExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $templateId = 'templateId1769642752';
        $template = new Template();
        $request = (new CreateTemplateRequest())
            ->setParent($formattedParent)
            ->setTemplateId($templateId)
            ->setTemplate($template);
        try {
            $gapicClient->createTemplate($request);
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
    public function createTemplateVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $disabled = true;
        $expectedResponse = new TemplateVersion();
        $expectedResponse->setName($name);
        $expectedResponse->setDisabled($disabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->templateName('[PROJECT]', '[LOCATION]', '[TEMPLATE]');
        $templateVersionId = 'templateVersionId2044583623';
        $templateVersion = new TemplateVersion();
        $templateVersionPayload = new TemplateVersionPayload();
        $payloadData = '88';
        $templateVersionPayload->setData($payloadData);
        $templateVersion->setPayload($templateVersionPayload);
        $request = (new CreateTemplateVersionRequest())
            ->setParent($formattedParent)
            ->setTemplateVersionId($templateVersionId)
            ->setTemplateVersion($templateVersion);
        $response = $gapicClient->createTemplateVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/CreateTemplateVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTemplateVersionId();
        $this->assertProtobufEquals($templateVersionId, $actualValue);
        $actualValue = $actualRequestObject->getTemplateVersion();
        $this->assertProtobufEquals($templateVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createTemplateVersionExceptionTest()
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
        $formattedParent = $gapicClient->templateName('[PROJECT]', '[LOCATION]', '[TEMPLATE]');
        $templateVersionId = 'templateVersionId2044583623';
        $templateVersion = new TemplateVersion();
        $templateVersionPayload = new TemplateVersionPayload();
        $payloadData = '88';
        $templateVersionPayload->setData($payloadData);
        $templateVersion->setPayload($templateVersionPayload);
        $request = (new CreateTemplateVersionRequest())
            ->setParent($formattedParent)
            ->setTemplateVersionId($templateVersionId)
            ->setTemplateVersion($templateVersion);
        try {
            $gapicClient->createTemplateVersion($request);
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
    public function deleteParameterTest()
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
        $formattedName = $gapicClient->parameterName('[PROJECT]', '[LOCATION]', '[PARAMETER]');
        $request = (new DeleteParameterRequest())->setName($formattedName);
        $gapicClient->deleteParameter($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/DeleteParameter', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteParameterExceptionTest()
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
        $formattedName = $gapicClient->parameterName('[PROJECT]', '[LOCATION]', '[PARAMETER]');
        $request = (new DeleteParameterRequest())->setName($formattedName);
        try {
            $gapicClient->deleteParameter($request);
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
    public function deleteParameterVersionTest()
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
        $formattedName = $gapicClient->parameterVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[PARAMETER]',
            '[PARAMETER_VERSION]'
        );
        $request = (new DeleteParameterVersionRequest())->setName($formattedName);
        $gapicClient->deleteParameterVersion($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/DeleteParameterVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteParameterVersionExceptionTest()
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
        $formattedName = $gapicClient->parameterVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[PARAMETER]',
            '[PARAMETER_VERSION]'
        );
        $request = (new DeleteParameterVersionRequest())->setName($formattedName);
        try {
            $gapicClient->deleteParameterVersion($request);
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
    public function deleteTemplateTest()
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
        $formattedName = $gapicClient->templateName('[PROJECT]', '[LOCATION]', '[TEMPLATE]');
        $request = (new DeleteTemplateRequest())->setName($formattedName);
        $gapicClient->deleteTemplate($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/DeleteTemplate', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteTemplateExceptionTest()
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
        $formattedName = $gapicClient->templateName('[PROJECT]', '[LOCATION]', '[TEMPLATE]');
        $request = (new DeleteTemplateRequest())->setName($formattedName);
        try {
            $gapicClient->deleteTemplate($request);
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
    public function deleteTemplateVersionTest()
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
        $formattedName = $gapicClient->templateVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[TEMPLATE]',
            '[TEMPLATE_VERSION]'
        );
        $request = (new DeleteTemplateVersionRequest())->setName($formattedName);
        $gapicClient->deleteTemplateVersion($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/DeleteTemplateVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteTemplateVersionExceptionTest()
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
        $formattedName = $gapicClient->templateVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[TEMPLATE]',
            '[TEMPLATE_VERSION]'
        );
        $request = (new DeleteTemplateVersionRequest())->setName($formattedName);
        try {
            $gapicClient->deleteTemplateVersion($request);
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
    public function getParameterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $kmsKey = 'kmsKey-591635343';
        $expectedResponse = new Parameter();
        $expectedResponse->setName($name2);
        $expectedResponse->setKmsKey($kmsKey);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->parameterName('[PROJECT]', '[LOCATION]', '[PARAMETER]');
        $request = (new GetParameterRequest())->setName($formattedName);
        $response = $gapicClient->getParameter($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/GetParameter', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getParameterExceptionTest()
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
        $formattedName = $gapicClient->parameterName('[PROJECT]', '[LOCATION]', '[PARAMETER]');
        $request = (new GetParameterRequest())->setName($formattedName);
        try {
            $gapicClient->getParameter($request);
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
    public function getParameterVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $disabled = true;
        $kmsKeyVersion = 'kmsKeyVersion207232778';
        $expectedResponse = new ParameterVersion();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setKmsKeyVersion($kmsKeyVersion);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->parameterVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[PARAMETER]',
            '[PARAMETER_VERSION]'
        );
        $request = (new GetParameterVersionRequest())->setName($formattedName);
        $response = $gapicClient->getParameterVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/GetParameterVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getParameterVersionExceptionTest()
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
        $formattedName = $gapicClient->parameterVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[PARAMETER]',
            '[PARAMETER_VERSION]'
        );
        $request = (new GetParameterVersionRequest())->setName($formattedName);
        try {
            $gapicClient->getParameterVersion($request);
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
    public function getTemplateTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new Template();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->templateName('[PROJECT]', '[LOCATION]', '[TEMPLATE]');
        $request = (new GetTemplateRequest())->setName($formattedName);
        $response = $gapicClient->getTemplate($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/GetTemplate', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTemplateExceptionTest()
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
        $formattedName = $gapicClient->templateName('[PROJECT]', '[LOCATION]', '[TEMPLATE]');
        $request = (new GetTemplateRequest())->setName($formattedName);
        try {
            $gapicClient->getTemplate($request);
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
    public function getTemplateVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $disabled = true;
        $expectedResponse = new TemplateVersion();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisabled($disabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->templateVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[TEMPLATE]',
            '[TEMPLATE_VERSION]'
        );
        $request = (new GetTemplateVersionRequest())->setName($formattedName);
        $response = $gapicClient->getTemplateVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/GetTemplateVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTemplateVersionExceptionTest()
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
        $formattedName = $gapicClient->templateVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[TEMPLATE]',
            '[TEMPLATE_VERSION]'
        );
        $request = (new GetTemplateVersionRequest())->setName($formattedName);
        try {
            $gapicClient->getTemplateVersion($request);
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
    public function listParameterVersionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $parameterVersionsElement = new ParameterVersion();
        $parameterVersions = [$parameterVersionsElement];
        $expectedResponse = new ListParameterVersionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setParameterVersions($parameterVersions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->parameterName('[PROJECT]', '[LOCATION]', '[PARAMETER]');
        $request = (new ListParameterVersionsRequest())->setParent($formattedParent);
        $response = $gapicClient->listParameterVersions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getParameterVersions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/ListParameterVersions', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listParameterVersionsExceptionTest()
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
        $formattedParent = $gapicClient->parameterName('[PROJECT]', '[LOCATION]', '[PARAMETER]');
        $request = (new ListParameterVersionsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listParameterVersions($request);
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
    public function listParametersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $parametersElement = new Parameter();
        $parameters = [$parametersElement];
        $expectedResponse = new ListParametersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setParameters($parameters);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListParametersRequest())->setParent($formattedParent);
        $response = $gapicClient->listParameters($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getParameters()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/ListParameters', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listParametersExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListParametersRequest())->setParent($formattedParent);
        try {
            $gapicClient->listParameters($request);
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
    public function listTemplateVersionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $templateVersionsElement = new TemplateVersion();
        $templateVersions = [$templateVersionsElement];
        $expectedResponse = new ListTemplateVersionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTemplateVersions($templateVersions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->templateName('[PROJECT]', '[LOCATION]', '[TEMPLATE]');
        $request = (new ListTemplateVersionsRequest())->setParent($formattedParent);
        $response = $gapicClient->listTemplateVersions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTemplateVersions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/ListTemplateVersions', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTemplateVersionsExceptionTest()
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
        $formattedParent = $gapicClient->templateName('[PROJECT]', '[LOCATION]', '[TEMPLATE]');
        $request = (new ListTemplateVersionsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listTemplateVersions($request);
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
    public function listTemplatesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $templatesElement = new Template();
        $templates = [$templatesElement];
        $expectedResponse = new ListTemplatesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTemplates($templates);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListTemplatesRequest())->setParent($formattedParent);
        $response = $gapicClient->listTemplates($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTemplates()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/ListTemplates', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTemplatesExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListTemplatesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listTemplates($request);
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
    public function renderParameterVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $parameterVersion = 'parameterVersion1926086210';
        $renderedPayload = '4';
        $expectedResponse = new RenderParameterVersionResponse();
        $expectedResponse->setParameterVersion($parameterVersion);
        $expectedResponse->setRenderedPayload($renderedPayload);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->parameterVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[PARAMETER]',
            '[PARAMETER_VERSION]'
        );
        $request = (new RenderParameterVersionRequest())->setName($formattedName);
        $response = $gapicClient->renderParameterVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/RenderParameterVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function renderParameterVersionExceptionTest()
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
        $formattedName = $gapicClient->parameterVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[PARAMETER]',
            '[PARAMETER_VERSION]'
        );
        $request = (new RenderParameterVersionRequest())->setName($formattedName);
        try {
            $gapicClient->renderParameterVersion($request);
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
    public function renderTemplateVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $templateVersion = 'templateVersion-1445956077';
        $renderedPayload = '4';
        $parameterVersion2 = 'parameterVersion2-162053771';
        $expectedResponse = new RenderTemplateVersionResponse();
        $expectedResponse->setTemplateVersion($templateVersion);
        $expectedResponse->setRenderedPayload($renderedPayload);
        $expectedResponse->setParameterVersion($parameterVersion2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->templateVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[TEMPLATE]',
            '[TEMPLATE_VERSION]'
        );
        $formattedParameterVersion = $gapicClient->parameterVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[PARAMETER]',
            '[PARAMETER_VERSION]'
        );
        $request = (new RenderTemplateVersionRequest())
            ->setName($formattedName)
            ->setParameterVersion($formattedParameterVersion);
        $response = $gapicClient->renderTemplateVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/RenderTemplateVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getParameterVersion();
        $this->assertProtobufEquals($formattedParameterVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function renderTemplateVersionExceptionTest()
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
        $formattedName = $gapicClient->templateVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[TEMPLATE]',
            '[TEMPLATE_VERSION]'
        );
        $formattedParameterVersion = $gapicClient->parameterVersionName(
            '[PROJECT]',
            '[LOCATION]',
            '[PARAMETER]',
            '[PARAMETER_VERSION]'
        );
        $request = (new RenderTemplateVersionRequest())
            ->setName($formattedName)
            ->setParameterVersion($formattedParameterVersion);
        try {
            $gapicClient->renderTemplateVersion($request);
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
    public function updateParameterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $kmsKey = 'kmsKey-591635343';
        $expectedResponse = new Parameter();
        $expectedResponse->setName($name);
        $expectedResponse->setKmsKey($kmsKey);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parameter = new Parameter();
        $request = (new UpdateParameterRequest())->setParameter($parameter);
        $response = $gapicClient->updateParameter($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/UpdateParameter', $actualFuncCall);
        $actualValue = $actualRequestObject->getParameter();
        $this->assertProtobufEquals($parameter, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateParameterExceptionTest()
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
        $parameter = new Parameter();
        $request = (new UpdateParameterRequest())->setParameter($parameter);
        try {
            $gapicClient->updateParameter($request);
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
    public function updateParameterVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $disabled = true;
        $kmsKeyVersion = 'kmsKeyVersion207232778';
        $expectedResponse = new ParameterVersion();
        $expectedResponse->setName($name);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setKmsKeyVersion($kmsKeyVersion);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parameterVersion = new ParameterVersion();
        $parameterVersionPayload = new ParameterVersionPayload();
        $payloadData = '88';
        $parameterVersionPayload->setData($payloadData);
        $parameterVersion->setPayload($parameterVersionPayload);
        $request = (new UpdateParameterVersionRequest())->setParameterVersion($parameterVersion);
        $response = $gapicClient->updateParameterVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/UpdateParameterVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getParameterVersion();
        $this->assertProtobufEquals($parameterVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateParameterVersionExceptionTest()
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
        $parameterVersion = new ParameterVersion();
        $parameterVersionPayload = new ParameterVersionPayload();
        $payloadData = '88';
        $parameterVersionPayload->setData($payloadData);
        $parameterVersion->setPayload($parameterVersionPayload);
        $request = (new UpdateParameterVersionRequest())->setParameterVersion($parameterVersion);
        try {
            $gapicClient->updateParameterVersion($request);
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
    public function updateTemplateTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new Template();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $template = new Template();
        $request = (new UpdateTemplateRequest())->setTemplate($template);
        $response = $gapicClient->updateTemplate($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/UpdateTemplate', $actualFuncCall);
        $actualValue = $actualRequestObject->getTemplate();
        $this->assertProtobufEquals($template, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateTemplateExceptionTest()
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
        $template = new Template();
        $request = (new UpdateTemplateRequest())->setTemplate($template);
        try {
            $gapicClient->updateTemplate($request);
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
    public function updateTemplateVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $disabled = true;
        $expectedResponse = new TemplateVersion();
        $expectedResponse->setName($name);
        $expectedResponse->setDisabled($disabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $templateVersion = new TemplateVersion();
        $templateVersionPayload = new TemplateVersionPayload();
        $payloadData = '88';
        $templateVersionPayload->setData($payloadData);
        $templateVersion->setPayload($templateVersionPayload);
        $request = (new UpdateTemplateVersionRequest())->setTemplateVersion($templateVersion);
        $response = $gapicClient->updateTemplateVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/UpdateTemplateVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getTemplateVersion();
        $this->assertProtobufEquals($templateVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateTemplateVersionExceptionTest()
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
        $templateVersion = new TemplateVersion();
        $templateVersionPayload = new TemplateVersionPayload();
        $payloadData = '88';
        $templateVersionPayload->setData($payloadData);
        $templateVersion->setPayload($templateVersionPayload);
        $request = (new UpdateTemplateVersionRequest())->setTemplateVersion($templateVersion);
        try {
            $gapicClient->updateTemplateVersion($request);
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
    public function getLocationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $locationId = 'locationId552319461';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Location();
        $expectedResponse->setName($name2);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        $request = new GetLocationRequest();
        $response = $gapicClient->getLocation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/GetLocation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLocationExceptionTest()
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
        $request = new GetLocationRequest();
        try {
            $gapicClient->getLocation($request);
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
    public function listLocationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $locationsElement = new Location();
        $locations = [$locationsElement];
        $expectedResponse = new ListLocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLocations($locations);
        $transport->addResponse($expectedResponse);
        $request = new ListLocationsRequest();
        $response = $gapicClient->listLocations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLocations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/ListLocations', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listLocationsExceptionTest()
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
        $request = new ListLocationsRequest();
        try {
            $gapicClient->listLocations($request);
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
    public function createParameterAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $kmsKey = 'kmsKey-591635343';
        $expectedResponse = new Parameter();
        $expectedResponse->setName($name);
        $expectedResponse->setKmsKey($kmsKey);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $parameterId = 'parameterId-1536249487';
        $parameter = new Parameter();
        $request = (new CreateParameterRequest())
            ->setParent($formattedParent)
            ->setParameterId($parameterId)
            ->setParameter($parameter);
        $response = $gapicClient->createParameterAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.parametermanager.v1.ParameterManager/CreateParameter', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getParameterId();
        $this->assertProtobufEquals($parameterId, $actualValue);
        $actualValue = $actualRequestObject->getParameter();
        $this->assertProtobufEquals($parameter, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
