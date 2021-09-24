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

namespace Google\Cloud\Talent\Tests\Unit\V4beta1;

use Google\ApiCore\ApiException;

use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;

use Google\Cloud\Talent\V4beta1\Company;
use Google\Cloud\Talent\V4beta1\CompanyServiceClient;
use Google\Cloud\Talent\V4beta1\ListCompaniesResponse;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group talent
 *
 * @group gapic
 */
class CompanyServiceClientTest extends GeneratedTest
{
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return CredentialsWrapper
     */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @return CompanyServiceClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CompanyServiceClient($options);
    }

    /**
     * @test
     */
    public function createCompanyTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $externalId = 'externalId-1153075697';
        $headquartersAddress = 'headquartersAddress-1879520036';
        $hiringAgency = false;
        $eeoText = 'eeoText-1652097123';
        $websiteUri = 'websiteUri-2118185016';
        $careerSiteUri = 'careerSiteUri1223331861';
        $imageUri = 'imageUri-877823864';
        $suspended = false;
        $expectedResponse = new Company();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setExternalId($externalId);
        $expectedResponse->setHeadquartersAddress($headquartersAddress);
        $expectedResponse->setHiringAgency($hiringAgency);
        $expectedResponse->setEeoText($eeoText);
        $expectedResponse->setWebsiteUri($websiteUri);
        $expectedResponse->setCareerSiteUri($careerSiteUri);
        $expectedResponse->setImageUri($imageUri);
        $expectedResponse->setSuspended($suspended);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');
        $company = new Company();
        $companyDisplayName = 'companyDisplayName-686915152';
        $company->setDisplayName($companyDisplayName);
        $companyExternalId = 'companyExternalId855180963';
        $company->setExternalId($companyExternalId);
        $response = $client->createCompany($formattedParent, $company);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.talent.v4beta1.CompanyService/CreateCompany', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCompany();
        $this->assertProtobufEquals($company, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createCompanyExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->projectName('[PROJECT]');
        $company = new Company();
        $companyDisplayName = 'companyDisplayName-686915152';
        $company->setDisplayName($companyDisplayName);
        $companyExternalId = 'companyExternalId855180963';
        $company->setExternalId($companyExternalId);
        try {
            $client->createCompany($formattedParent, $company);
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
    public function deleteCompanyTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->companyName('[PROJECT]', '[TENANT]', '[COMPANY]');
        $client->deleteCompany($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.talent.v4beta1.CompanyService/DeleteCompany', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteCompanyExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->companyName('[PROJECT]', '[TENANT]', '[COMPANY]');
        try {
            $client->deleteCompany($formattedName);
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
    public function getCompanyTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $externalId = 'externalId-1153075697';
        $headquartersAddress = 'headquartersAddress-1879520036';
        $hiringAgency = false;
        $eeoText = 'eeoText-1652097123';
        $websiteUri = 'websiteUri-2118185016';
        $careerSiteUri = 'careerSiteUri1223331861';
        $imageUri = 'imageUri-877823864';
        $suspended = false;
        $expectedResponse = new Company();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setExternalId($externalId);
        $expectedResponse->setHeadquartersAddress($headquartersAddress);
        $expectedResponse->setHiringAgency($hiringAgency);
        $expectedResponse->setEeoText($eeoText);
        $expectedResponse->setWebsiteUri($websiteUri);
        $expectedResponse->setCareerSiteUri($careerSiteUri);
        $expectedResponse->setImageUri($imageUri);
        $expectedResponse->setSuspended($suspended);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->companyName('[PROJECT]', '[TENANT]', '[COMPANY]');
        $response = $client->getCompany($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.talent.v4beta1.CompanyService/GetCompany', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getCompanyExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->companyName('[PROJECT]', '[TENANT]', '[COMPANY]');
        try {
            $client->getCompany($formattedName);
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
    public function listCompaniesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $companiesElement = new Company();
        $companies = [
            $companiesElement,
        ];
        $expectedResponse = new ListCompaniesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCompanies($companies);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');
        $response = $client->listCompanies($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCompanies()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.talent.v4beta1.CompanyService/ListCompanies', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listCompaniesExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->projectName('[PROJECT]');
        try {
            $client->listCompanies($formattedParent);
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
    public function updateCompanyTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $externalId = 'externalId-1153075697';
        $headquartersAddress = 'headquartersAddress-1879520036';
        $hiringAgency = false;
        $eeoText = 'eeoText-1652097123';
        $websiteUri = 'websiteUri-2118185016';
        $careerSiteUri = 'careerSiteUri1223331861';
        $imageUri = 'imageUri-877823864';
        $suspended = false;
        $expectedResponse = new Company();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setExternalId($externalId);
        $expectedResponse->setHeadquartersAddress($headquartersAddress);
        $expectedResponse->setHiringAgency($hiringAgency);
        $expectedResponse->setEeoText($eeoText);
        $expectedResponse->setWebsiteUri($websiteUri);
        $expectedResponse->setCareerSiteUri($careerSiteUri);
        $expectedResponse->setImageUri($imageUri);
        $expectedResponse->setSuspended($suspended);
        $transport->addResponse($expectedResponse);
        // Mock request
        $company = new Company();
        $companyDisplayName = 'companyDisplayName-686915152';
        $company->setDisplayName($companyDisplayName);
        $companyExternalId = 'companyExternalId855180963';
        $company->setExternalId($companyExternalId);
        $response = $client->updateCompany($company);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.talent.v4beta1.CompanyService/UpdateCompany', $actualFuncCall);
        $actualValue = $actualRequestObject->getCompany();
        $this->assertProtobufEquals($company, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateCompanyExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $company = new Company();
        $companyDisplayName = 'companyDisplayName-686915152';
        $company->setDisplayName($companyDisplayName);
        $companyExternalId = 'companyExternalId855180963';
        $company->setExternalId($companyExternalId);
        try {
            $client->updateCompany($company);
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
