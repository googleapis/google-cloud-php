<?php
/*
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Dlp\Tests\Unit\V2;

use Google\Cloud\Dlp\V2\DlpServiceClient;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Dlp\V2\DeidentifyContentResponse;
use Google\Cloud\Dlp\V2\DeidentifyTemplate;
use Google\Cloud\Dlp\V2\DlpJob;
use Google\Cloud\Dlp\V2\InspectContentResponse;
use Google\Cloud\Dlp\V2\InspectTemplate;
use Google\Cloud\Dlp\V2\JobTrigger;
use Google\Cloud\Dlp\V2\ListDeidentifyTemplatesResponse;
use Google\Cloud\Dlp\V2\ListDlpJobsResponse;
use Google\Cloud\Dlp\V2\ListInfoTypesResponse;
use Google\Cloud\Dlp\V2\ListInspectTemplatesResponse;
use Google\Cloud\Dlp\V2\ListJobTriggersResponse;
use Google\Cloud\Dlp\V2\RedactImageResponse;
use Google\Cloud\Dlp\V2\ReidentifyContentResponse;
use Google\Protobuf\Any;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group dlp
 * @group grpc
 */
class DlpServiceClientTest extends GeneratedTest
{
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return DlpServiceClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->getMockBuilder(CredentialsWrapper::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        return new DlpServiceClient($options);
    }

    /**
     * @test
     */
    public function inspectContentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new InspectContentResponse();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');

        $response = $client->inspectContent($formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/InspectContent', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function inspectContentExceptionTest()
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

        try {
            $client->inspectContent($formattedParent);
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
    public function redactImageTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $redactedImage = '28';
        $extractedText = 'extractedText998260012';
        $expectedResponse = new RedactImageResponse();
        $expectedResponse->setRedactedImage($redactedImage);
        $expectedResponse->setExtractedText($extractedText);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');

        $response = $client->redactImage($formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/RedactImage', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function redactImageExceptionTest()
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

        try {
            $client->redactImage($formattedParent);
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
    public function deidentifyContentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new DeidentifyContentResponse();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');

        $response = $client->deidentifyContent($formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/DeidentifyContent', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deidentifyContentExceptionTest()
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

        try {
            $client->deidentifyContent($formattedParent);
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
    public function reidentifyContentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new ReidentifyContentResponse();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');

        $response = $client->reidentifyContent($formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/ReidentifyContent', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function reidentifyContentExceptionTest()
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

        try {
            $client->reidentifyContent($formattedParent);
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
    public function listInfoTypesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new ListInfoTypesResponse();
        $transport->addResponse($expectedResponse);

        $response = $client->listInfoTypes();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/ListInfoTypes', $actualFuncCall);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listInfoTypesExceptionTest()
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

        try {
            $client->listInfoTypes();
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
    public function createInspectTemplateTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new InspectTemplate();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->organizationName('[ORGANIZATION]');

        $response = $client->createInspectTemplate($formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/CreateInspectTemplate', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createInspectTemplateExceptionTest()
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
        $formattedParent = $client->organizationName('[ORGANIZATION]');

        try {
            $client->createInspectTemplate($formattedParent);
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
    public function updateInspectTemplateTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new InspectTemplate();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->organizationInspectTemplateName('[ORGANIZATION]', '[INSPECT_TEMPLATE]');

        $response = $client->updateInspectTemplate($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/UpdateInspectTemplate', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateInspectTemplateExceptionTest()
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
        $formattedName = $client->organizationInspectTemplateName('[ORGANIZATION]', '[INSPECT_TEMPLATE]');

        try {
            $client->updateInspectTemplate($formattedName);
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
    public function getInspectTemplateTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new InspectTemplate();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);

        $response = $client->getInspectTemplate();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/GetInspectTemplate', $actualFuncCall);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getInspectTemplateExceptionTest()
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

        try {
            $client->getInspectTemplate();
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
    public function listInspectTemplatesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $nextPageToken = '';
        $inspectTemplatesElement = new InspectTemplate();
        $inspectTemplates = [$inspectTemplatesElement];
        $expectedResponse = new ListInspectTemplatesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setInspectTemplates($inspectTemplates);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->organizationName('[ORGANIZATION]');

        $response = $client->listInspectTemplates($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getInspectTemplates()[0], $resources[0]);

        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/ListInspectTemplates', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listInspectTemplatesExceptionTest()
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
        $formattedParent = $client->organizationName('[ORGANIZATION]');

        try {
            $client->listInspectTemplates($formattedParent);
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
    public function deleteInspectTemplateTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->organizationInspectTemplateName('[ORGANIZATION]', '[INSPECT_TEMPLATE]');

        $client->deleteInspectTemplate($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/DeleteInspectTemplate', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteInspectTemplateExceptionTest()
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
        $formattedName = $client->organizationInspectTemplateName('[ORGANIZATION]', '[INSPECT_TEMPLATE]');

        try {
            $client->deleteInspectTemplate($formattedName);
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
    public function createDeidentifyTemplateTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new DeidentifyTemplate();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->organizationName('[ORGANIZATION]');

        $response = $client->createDeidentifyTemplate($formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/CreateDeidentifyTemplate', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createDeidentifyTemplateExceptionTest()
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
        $formattedParent = $client->organizationName('[ORGANIZATION]');

        try {
            $client->createDeidentifyTemplate($formattedParent);
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
    public function updateDeidentifyTemplateTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new DeidentifyTemplate();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->organizationDeidentifyTemplateName('[ORGANIZATION]', '[DEIDENTIFY_TEMPLATE]');

        $response = $client->updateDeidentifyTemplate($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/UpdateDeidentifyTemplate', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateDeidentifyTemplateExceptionTest()
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
        $formattedName = $client->organizationDeidentifyTemplateName('[ORGANIZATION]', '[DEIDENTIFY_TEMPLATE]');

        try {
            $client->updateDeidentifyTemplate($formattedName);
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
    public function getDeidentifyTemplateTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new DeidentifyTemplate();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->organizationDeidentifyTemplateName('[ORGANIZATION]', '[DEIDENTIFY_TEMPLATE]');

        $response = $client->getDeidentifyTemplate($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/GetDeidentifyTemplate', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getDeidentifyTemplateExceptionTest()
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
        $formattedName = $client->organizationDeidentifyTemplateName('[ORGANIZATION]', '[DEIDENTIFY_TEMPLATE]');

        try {
            $client->getDeidentifyTemplate($formattedName);
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
    public function listDeidentifyTemplatesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $nextPageToken = '';
        $deidentifyTemplatesElement = new DeidentifyTemplate();
        $deidentifyTemplates = [$deidentifyTemplatesElement];
        $expectedResponse = new ListDeidentifyTemplatesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDeidentifyTemplates($deidentifyTemplates);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->organizationName('[ORGANIZATION]');

        $response = $client->listDeidentifyTemplates($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDeidentifyTemplates()[0], $resources[0]);

        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/ListDeidentifyTemplates', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listDeidentifyTemplatesExceptionTest()
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
        $formattedParent = $client->organizationName('[ORGANIZATION]');

        try {
            $client->listDeidentifyTemplates($formattedParent);
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
    public function deleteDeidentifyTemplateTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->organizationDeidentifyTemplateName('[ORGANIZATION]', '[DEIDENTIFY_TEMPLATE]');

        $client->deleteDeidentifyTemplate($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/DeleteDeidentifyTemplate', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteDeidentifyTemplateExceptionTest()
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
        $formattedName = $client->organizationDeidentifyTemplateName('[ORGANIZATION]', '[DEIDENTIFY_TEMPLATE]');

        try {
            $client->deleteDeidentifyTemplate($formattedName);
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
    public function createDlpJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $jobTriggerName = 'jobTriggerName1819490804';
        $expectedResponse = new DlpJob();
        $expectedResponse->setName($name);
        $expectedResponse->setJobTriggerName($jobTriggerName);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');

        $response = $client->createDlpJob($formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/CreateDlpJob', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createDlpJobExceptionTest()
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

        try {
            $client->createDlpJob($formattedParent);
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
    public function listDlpJobsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $nextPageToken = '';
        $jobsElement = new DlpJob();
        $jobs = [$jobsElement];
        $expectedResponse = new ListDlpJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setJobs($jobs);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');

        $response = $client->listDlpJobs($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getJobs()[0], $resources[0]);

        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/ListDlpJobs', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listDlpJobsExceptionTest()
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

        try {
            $client->listDlpJobs($formattedParent);
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
    public function getDlpJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name2 = 'name2-1052831874';
        $jobTriggerName = 'jobTriggerName1819490804';
        $expectedResponse = new DlpJob();
        $expectedResponse->setName($name2);
        $expectedResponse->setJobTriggerName($jobTriggerName);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->dlpJobName('[PROJECT]', '[DLP_JOB]');

        $response = $client->getDlpJob($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/GetDlpJob', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getDlpJobExceptionTest()
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
        $formattedName = $client->dlpJobName('[PROJECT]', '[DLP_JOB]');

        try {
            $client->getDlpJob($formattedName);
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
    public function deleteDlpJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->dlpJobName('[PROJECT]', '[DLP_JOB]');

        $client->deleteDlpJob($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/DeleteDlpJob', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteDlpJobExceptionTest()
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
        $formattedName = $client->dlpJobName('[PROJECT]', '[DLP_JOB]');

        try {
            $client->deleteDlpJob($formattedName);
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
    public function cancelDlpJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->dlpJobName('[PROJECT]', '[DLP_JOB]');

        $client->cancelDlpJob($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/CancelDlpJob', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function cancelDlpJobExceptionTest()
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
        $formattedName = $client->dlpJobName('[PROJECT]', '[DLP_JOB]');

        try {
            $client->cancelDlpJob($formattedName);
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
    public function listJobTriggersTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $nextPageToken = '';
        $jobTriggersElement = new JobTrigger();
        $jobTriggers = [$jobTriggersElement];
        $expectedResponse = new ListJobTriggersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setJobTriggers($jobTriggers);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');

        $response = $client->listJobTriggers($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getJobTriggers()[0], $resources[0]);

        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/ListJobTriggers', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listJobTriggersExceptionTest()
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

        try {
            $client->listJobTriggers($formattedParent);
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
    public function getJobTriggerTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new JobTrigger();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->projectJobTriggerName('[PROJECT]', '[JOB_TRIGGER]');

        $response = $client->getJobTrigger($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/GetJobTrigger', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getJobTriggerExceptionTest()
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
        $formattedName = $client->projectJobTriggerName('[PROJECT]', '[JOB_TRIGGER]');

        try {
            $client->getJobTrigger($formattedName);
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
    public function deleteJobTriggerTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);

        // Mock request
        $name = 'name3373707';

        $client->deleteJobTrigger($name);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/DeleteJobTrigger', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($name, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteJobTriggerExceptionTest()
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
        $name = 'name3373707';

        try {
            $client->deleteJobTrigger($name);
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
    public function updateJobTriggerTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new JobTrigger();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->projectJobTriggerName('[PROJECT]', '[JOB_TRIGGER]');

        $response = $client->updateJobTrigger($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/UpdateJobTrigger', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateJobTriggerExceptionTest()
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
        $formattedName = $client->projectJobTriggerName('[PROJECT]', '[JOB_TRIGGER]');

        try {
            $client->updateJobTrigger($formattedName);
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
    public function createJobTriggerTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new JobTrigger();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');

        $response = $client->createJobTrigger($formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.privacy.dlp.v2.DlpService/CreateJobTrigger', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createJobTriggerExceptionTest()
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

        try {
            $client->createJobTrigger($formattedParent);
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
