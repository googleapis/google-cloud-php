<?php
/*
 * Copyright 2024 Google LLC
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

namespace Google\Ads\AdManager\Tests\Unit\V1\Client;

use Google\Ads\AdManager\V1\Client\CompanyServiceClient;
use Google\Ads\AdManager\V1\Company;
use Google\Ads\AdManager\V1\GetCompanyRequest;
use Google\Ads\AdManager\V1\ListCompaniesRequest;
use Google\Ads\AdManager\V1\ListCompaniesResponse;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class CompanyServiceClientTest extends GeneratedTest
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

    /** @return CompanyServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CompanyServiceClient($options);
    }

    /** @test */
    public function getCompanyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $companyId = 847673315;
        $displayName = 'displayName1615086568';
        $address = 'address-1147692044';
        $email = 'email96619420';
        $fax = 'fax101149';
        $phone = 'phone106642798';
        $externalId = 'externalId-1153075697';
        $comment = 'comment950398559';
        $primaryContact = 'primaryContact203339491';
        $thirdPartyCompanyId = 2003341038;
        $expectedResponse = new Company();
        $expectedResponse->setName($name2);
        $expectedResponse->setCompanyId($companyId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAddress($address);
        $expectedResponse->setEmail($email);
        $expectedResponse->setFax($fax);
        $expectedResponse->setPhone($phone);
        $expectedResponse->setExternalId($externalId);
        $expectedResponse->setComment($comment);
        $expectedResponse->setPrimaryContact($primaryContact);
        $expectedResponse->setThirdPartyCompanyId($thirdPartyCompanyId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->companyName('[NETWORK_CODE]', '[COMPANY]');
        $request = (new GetCompanyRequest())->setName($formattedName);
        $response = $gapicClient->getCompany($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CompanyService/GetCompany', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCompanyExceptionTest()
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
        $formattedName = $gapicClient->companyName('[NETWORK_CODE]', '[COMPANY]');
        $request = (new GetCompanyRequest())->setName($formattedName);
        try {
            $gapicClient->getCompany($request);
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
    public function listCompaniesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $companiesElement = new Company();
        $companies = [$companiesElement];
        $expectedResponse = new ListCompaniesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setCompanies($companies);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListCompaniesRequest())->setParent($formattedParent);
        $response = $gapicClient->listCompanies($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCompanies()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CompanyService/ListCompanies', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCompaniesExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListCompaniesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCompanies($request);
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
    public function getCompanyAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $companyId = 847673315;
        $displayName = 'displayName1615086568';
        $address = 'address-1147692044';
        $email = 'email96619420';
        $fax = 'fax101149';
        $phone = 'phone106642798';
        $externalId = 'externalId-1153075697';
        $comment = 'comment950398559';
        $primaryContact = 'primaryContact203339491';
        $thirdPartyCompanyId = 2003341038;
        $expectedResponse = new Company();
        $expectedResponse->setName($name2);
        $expectedResponse->setCompanyId($companyId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAddress($address);
        $expectedResponse->setEmail($email);
        $expectedResponse->setFax($fax);
        $expectedResponse->setPhone($phone);
        $expectedResponse->setExternalId($externalId);
        $expectedResponse->setComment($comment);
        $expectedResponse->setPrimaryContact($primaryContact);
        $expectedResponse->setThirdPartyCompanyId($thirdPartyCompanyId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->companyName('[NETWORK_CODE]', '[COMPANY]');
        $request = (new GetCompanyRequest())->setName($formattedName);
        $response = $gapicClient->getCompanyAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CompanyService/GetCompany', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
