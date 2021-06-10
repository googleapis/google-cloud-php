<?php
/*
 * Copyright 2021 Google LLC
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

namespace Google\Cloud\Security\PrivateCA\Tests\Unit\V1beta1;

use Google\ApiCore\ApiException;

use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;

use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Security\PrivateCA\V1beta1\Certificate;

use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority\KeyVersionSpec;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority\SignHashAlgorithm;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority\Tier;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority\Type;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthorityServiceClient;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateConfig;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateConfig\SubjectConfig;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateRevocationList;
use Google\Cloud\Security\PrivateCA\V1beta1\FetchCertificateAuthorityCsrResponse;
use Google\Cloud\Security\PrivateCA\V1beta1\ListCertificateAuthoritiesResponse;
use Google\Cloud\Security\PrivateCA\V1beta1\ListCertificateRevocationListsResponse;
use Google\Cloud\Security\PrivateCA\V1beta1\ListCertificatesResponse;
use Google\Cloud\Security\PrivateCA\V1beta1\ListReusableConfigsResponse;
use Google\Cloud\Security\PrivateCA\V1beta1\ReusableConfig;
use Google\Cloud\Security\PrivateCA\V1beta1\ReusableConfigValues;
use Google\Cloud\Security\PrivateCA\V1beta1\ReusableConfigWrapper;
use Google\Cloud\Security\PrivateCA\V1beta1\RevocationReason;
use Google\Cloud\Security\PrivateCA\V1beta1\Subject;
use Google\Cloud\Security\PrivateCA\V1beta1\SubordinateConfig;
use Google\Cloud\Security\PrivateCA\V1beta1\SubordinateConfig\SubordinateConfigChain;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use stdClass;

/**
 * @group privateca
 *
 * @group gapic
 */
class CertificateAuthorityServiceClientTest extends GeneratedTest
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
     * @return CertificateAuthorityServiceClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CertificateAuthorityServiceClient($options);
    }

    /**
     * @test
     */
    public function activateCertificateAuthorityTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/activateCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $gcsBucket = 'gcsBucket-1720393710';
        $expectedResponse = new CertificateAuthority();
        $expectedResponse->setName($name2);
        $expectedResponse->setGcsBucket($gcsBucket);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/activateCertificateAuthorityTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $pemCaCertificate = 'pemCaCertificate1041594685';
        $subordinateConfig = new SubordinateConfig();
        $subordinateConfigCertificateAuthority = 'subordinateConfigCertificateAuthority-722261446';
        $subordinateConfig->setCertificateAuthority($subordinateConfigCertificateAuthority);
        $subordinateConfigPemIssuerChain = new SubordinateConfigChain();
        $pemIssuerChainPemCertificates = [];
        $subordinateConfigPemIssuerChain->setPemCertificates($pemIssuerChainPemCertificates);
        $subordinateConfig->setPemIssuerChain($subordinateConfigPemIssuerChain);
        $response = $client->activateCertificateAuthority($formattedName, $pemCaCertificate, $subordinateConfig);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/ActivateCertificateAuthority', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualApiRequestObject->getPemCaCertificate();
        $this->assertProtobufEquals($pemCaCertificate, $actualValue);
        $actualValue = $actualApiRequestObject->getSubordinateConfig();
        $this->assertProtobufEquals($subordinateConfig, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/activateCertificateAuthorityTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function activateCertificateAuthorityExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/activateCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $pemCaCertificate = 'pemCaCertificate1041594685';
        $subordinateConfig = new SubordinateConfig();
        $subordinateConfigCertificateAuthority = 'subordinateConfigCertificateAuthority-722261446';
        $subordinateConfig->setCertificateAuthority($subordinateConfigCertificateAuthority);
        $subordinateConfigPemIssuerChain = new SubordinateConfigChain();
        $pemIssuerChainPemCertificates = [];
        $subordinateConfigPemIssuerChain->setPemCertificates($pemIssuerChainPemCertificates);
        $subordinateConfig->setPemIssuerChain($subordinateConfigPemIssuerChain);
        $response = $client->activateCertificateAuthority($formattedName, $pemCaCertificate, $subordinateConfig);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/activateCertificateAuthorityTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function createCertificateTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $pemCsr = 'pemCsr-683665829';
        $pemCertificate = 'pemCertificate1234463984';
        $expectedResponse = new Certificate();
        $expectedResponse->setName($name);
        $expectedResponse->setPemCsr($pemCsr);
        $expectedResponse->setPemCertificate($pemCertificate);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $certificate = new Certificate();
        $certificateLifetime = new Duration();
        $certificate->setLifetime($certificateLifetime);
        $response = $client->createCertificate($formattedParent, $certificate);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/CreateCertificate', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCertificate();
        $this->assertProtobufEquals($certificate, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createCertificateExceptionTest()
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
        $formattedParent = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $certificate = new Certificate();
        $certificateLifetime = new Duration();
        $certificate->setLifetime($certificateLifetime);
        try {
            $client->createCertificate($formattedParent, $certificate);
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
    public function createCertificateAuthorityTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $gcsBucket = 'gcsBucket-1720393710';
        $expectedResponse = new CertificateAuthority();
        $expectedResponse->setName($name);
        $expectedResponse->setGcsBucket($gcsBucket);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createCertificateAuthorityTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $certificateAuthorityId = 'certificateAuthorityId561919295';
        $certificateAuthority = new CertificateAuthority();
        $certificateAuthorityType = Type::TYPE_UNSPECIFIED;
        $certificateAuthority->setType($certificateAuthorityType);
        $certificateAuthorityTier = Tier::TIER_UNSPECIFIED;
        $certificateAuthority->setTier($certificateAuthorityTier);
        $certificateAuthorityConfig = new CertificateConfig();
        $configSubjectConfig = new SubjectConfig();
        $subjectConfigSubject = new Subject();
        $configSubjectConfig->setSubject($subjectConfigSubject);
        $certificateAuthorityConfig->setSubjectConfig($configSubjectConfig);
        $configReusableConfig = new ReusableConfigWrapper();
        $reusableConfigReusableConfig = 'reusableConfigReusableConfig424335738';
        $configReusableConfig->setReusableConfig($reusableConfigReusableConfig);
        $reusableConfigReusableConfigValues = new ReusableConfigValues();
        $configReusableConfig->setReusableConfigValues($reusableConfigReusableConfigValues);
        $certificateAuthorityConfig->setReusableConfig($configReusableConfig);
        $certificateAuthority->setConfig($certificateAuthorityConfig);
        $certificateAuthorityLifetime = new Duration();
        $certificateAuthority->setLifetime($certificateAuthorityLifetime);
        $certificateAuthorityKeySpec = new KeyVersionSpec();
        $keySpecCloudKmsKeyVersion = 'keySpecCloudKmsKeyVersion170335183';
        $certificateAuthorityKeySpec->setCloudKmsKeyVersion($keySpecCloudKmsKeyVersion);
        $keySpecAlgorithm = SignHashAlgorithm::SIGN_HASH_ALGORITHM_UNSPECIFIED;
        $certificateAuthorityKeySpec->setAlgorithm($keySpecAlgorithm);
        $certificateAuthority->setKeySpec($certificateAuthorityKeySpec);
        $response = $client->createCertificateAuthority($formattedParent, $certificateAuthorityId, $certificateAuthority);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/CreateCertificateAuthority', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getCertificateAuthorityId();
        $this->assertProtobufEquals($certificateAuthorityId, $actualValue);
        $actualValue = $actualApiRequestObject->getCertificateAuthority();
        $this->assertProtobufEquals($certificateAuthority, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createCertificateAuthorityTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function createCertificateAuthorityExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $certificateAuthorityId = 'certificateAuthorityId561919295';
        $certificateAuthority = new CertificateAuthority();
        $certificateAuthorityType = Type::TYPE_UNSPECIFIED;
        $certificateAuthority->setType($certificateAuthorityType);
        $certificateAuthorityTier = Tier::TIER_UNSPECIFIED;
        $certificateAuthority->setTier($certificateAuthorityTier);
        $certificateAuthorityConfig = new CertificateConfig();
        $configSubjectConfig = new SubjectConfig();
        $subjectConfigSubject = new Subject();
        $configSubjectConfig->setSubject($subjectConfigSubject);
        $certificateAuthorityConfig->setSubjectConfig($configSubjectConfig);
        $configReusableConfig = new ReusableConfigWrapper();
        $reusableConfigReusableConfig = 'reusableConfigReusableConfig424335738';
        $configReusableConfig->setReusableConfig($reusableConfigReusableConfig);
        $reusableConfigReusableConfigValues = new ReusableConfigValues();
        $configReusableConfig->setReusableConfigValues($reusableConfigReusableConfigValues);
        $certificateAuthorityConfig->setReusableConfig($configReusableConfig);
        $certificateAuthority->setConfig($certificateAuthorityConfig);
        $certificateAuthorityLifetime = new Duration();
        $certificateAuthority->setLifetime($certificateAuthorityLifetime);
        $certificateAuthorityKeySpec = new KeyVersionSpec();
        $keySpecCloudKmsKeyVersion = 'keySpecCloudKmsKeyVersion170335183';
        $certificateAuthorityKeySpec->setCloudKmsKeyVersion($keySpecCloudKmsKeyVersion);
        $keySpecAlgorithm = SignHashAlgorithm::SIGN_HASH_ALGORITHM_UNSPECIFIED;
        $certificateAuthorityKeySpec->setAlgorithm($keySpecAlgorithm);
        $certificateAuthority->setKeySpec($certificateAuthorityKeySpec);
        $response = $client->createCertificateAuthority($formattedParent, $certificateAuthorityId, $certificateAuthority);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createCertificateAuthorityTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function disableCertificateAuthorityTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/disableCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $gcsBucket = 'gcsBucket-1720393710';
        $expectedResponse = new CertificateAuthority();
        $expectedResponse->setName($name2);
        $expectedResponse->setGcsBucket($gcsBucket);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/disableCertificateAuthorityTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $response = $client->disableCertificateAuthority($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/DisableCertificateAuthority', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/disableCertificateAuthorityTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function disableCertificateAuthorityExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/disableCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $response = $client->disableCertificateAuthority($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/disableCertificateAuthorityTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function enableCertificateAuthorityTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/enableCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $gcsBucket = 'gcsBucket-1720393710';
        $expectedResponse = new CertificateAuthority();
        $expectedResponse->setName($name2);
        $expectedResponse->setGcsBucket($gcsBucket);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/enableCertificateAuthorityTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $response = $client->enableCertificateAuthority($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/EnableCertificateAuthority', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/enableCertificateAuthorityTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function enableCertificateAuthorityExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/enableCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $response = $client->enableCertificateAuthority($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/enableCertificateAuthorityTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function fetchCertificateAuthorityCsrTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $pemCsr = 'pemCsr-683665829';
        $expectedResponse = new FetchCertificateAuthorityCsrResponse();
        $expectedResponse->setPemCsr($pemCsr);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $response = $client->fetchCertificateAuthorityCsr($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/FetchCertificateAuthorityCsr', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function fetchCertificateAuthorityCsrExceptionTest()
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
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        try {
            $client->fetchCertificateAuthorityCsr($formattedName);
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
    public function getCertificateTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $pemCsr = 'pemCsr-683665829';
        $pemCertificate = 'pemCertificate1234463984';
        $expectedResponse = new Certificate();
        $expectedResponse->setName($name2);
        $expectedResponse->setPemCsr($pemCsr);
        $expectedResponse->setPemCertificate($pemCertificate);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->certificateName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]', '[CERTIFICATE]');
        $response = $client->getCertificate($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/GetCertificate', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getCertificateExceptionTest()
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
        $formattedName = $client->certificateName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]', '[CERTIFICATE]');
        try {
            $client->getCertificate($formattedName);
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
    public function getCertificateAuthorityTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $gcsBucket = 'gcsBucket-1720393710';
        $expectedResponse = new CertificateAuthority();
        $expectedResponse->setName($name2);
        $expectedResponse->setGcsBucket($gcsBucket);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $response = $client->getCertificateAuthority($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/GetCertificateAuthority', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getCertificateAuthorityExceptionTest()
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
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        try {
            $client->getCertificateAuthority($formattedName);
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
    public function getCertificateRevocationListTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $sequenceNumber = 1309190777;
        $pemCrl = 'pemCrl-683665866';
        $accessUrl = 'accessUrl-1141680108';
        $expectedResponse = new CertificateRevocationList();
        $expectedResponse->setName($name2);
        $expectedResponse->setSequenceNumber($sequenceNumber);
        $expectedResponse->setPemCrl($pemCrl);
        $expectedResponse->setAccessUrl($accessUrl);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->certificateRevocationListName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]', '[CERTIFICATE_REVOCATION_LIST]');
        $response = $client->getCertificateRevocationList($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/GetCertificateRevocationList', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getCertificateRevocationListExceptionTest()
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
        $formattedName = $client->certificateRevocationListName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]', '[CERTIFICATE_REVOCATION_LIST]');
        try {
            $client->getCertificateRevocationList($formattedName);
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
    public function getReusableConfigTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $expectedResponse = new ReusableConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->reusableConfigName('[PROJECT]', '[LOCATION]', '[REUSABLE_CONFIG]');
        $response = $client->getReusableConfig($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/GetReusableConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getReusableConfigExceptionTest()
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
        $formattedName = $client->reusableConfigName('[PROJECT]', '[LOCATION]', '[REUSABLE_CONFIG]');
        try {
            $client->getReusableConfig($formattedName);
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
    public function listCertificateAuthoritiesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $certificateAuthoritiesElement = new CertificateAuthority();
        $certificateAuthorities = [
            $certificateAuthoritiesElement,
        ];
        $expectedResponse = new ListCertificateAuthoritiesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCertificateAuthorities($certificateAuthorities);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $response = $client->listCertificateAuthorities($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCertificateAuthorities()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/ListCertificateAuthorities', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listCertificateAuthoritiesExceptionTest()
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        try {
            $client->listCertificateAuthorities($formattedParent);
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
    public function listCertificateRevocationListsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $certificateRevocationListsElement = new CertificateRevocationList();
        $certificateRevocationLists = [
            $certificateRevocationListsElement,
        ];
        $expectedResponse = new ListCertificateRevocationListsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCertificateRevocationLists($certificateRevocationLists);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $response = $client->listCertificateRevocationLists($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCertificateRevocationLists()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/ListCertificateRevocationLists', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listCertificateRevocationListsExceptionTest()
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
        $formattedParent = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        try {
            $client->listCertificateRevocationLists($formattedParent);
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
    public function listCertificatesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $certificatesElement = new Certificate();
        $certificates = [
            $certificatesElement,
        ];
        $expectedResponse = new ListCertificatesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCertificates($certificates);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $response = $client->listCertificates($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCertificates()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/ListCertificates', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listCertificatesExceptionTest()
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
        $formattedParent = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        try {
            $client->listCertificates($formattedParent);
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
    public function listReusableConfigsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $reusableConfigsElement = new ReusableConfig();
        $reusableConfigs = [
            $reusableConfigsElement,
        ];
        $expectedResponse = new ListReusableConfigsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setReusableConfigs($reusableConfigs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $response = $client->listReusableConfigs($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getReusableConfigs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/ListReusableConfigs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listReusableConfigsExceptionTest()
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        try {
            $client->listReusableConfigs($formattedParent);
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
    public function restoreCertificateAuthorityTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/restoreCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $gcsBucket = 'gcsBucket-1720393710';
        $expectedResponse = new CertificateAuthority();
        $expectedResponse->setName($name2);
        $expectedResponse->setGcsBucket($gcsBucket);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/restoreCertificateAuthorityTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $response = $client->restoreCertificateAuthority($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/RestoreCertificateAuthority', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/restoreCertificateAuthorityTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function restoreCertificateAuthorityExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/restoreCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $response = $client->restoreCertificateAuthority($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/restoreCertificateAuthorityTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function revokeCertificateTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $pemCsr = 'pemCsr-683665829';
        $pemCertificate = 'pemCertificate1234463984';
        $expectedResponse = new Certificate();
        $expectedResponse->setName($name2);
        $expectedResponse->setPemCsr($pemCsr);
        $expectedResponse->setPemCertificate($pemCertificate);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->certificateName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]', '[CERTIFICATE]');
        $reason = RevocationReason::REVOCATION_REASON_UNSPECIFIED;
        $response = $client->revokeCertificate($formattedName, $reason);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/RevokeCertificate', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getReason();
        $this->assertProtobufEquals($reason, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function revokeCertificateExceptionTest()
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
        $formattedName = $client->certificateName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]', '[CERTIFICATE]');
        $reason = RevocationReason::REVOCATION_REASON_UNSPECIFIED;
        try {
            $client->revokeCertificate($formattedName, $reason);
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
    public function scheduleDeleteCertificateAuthorityTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/scheduleDeleteCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $gcsBucket = 'gcsBucket-1720393710';
        $expectedResponse = new CertificateAuthority();
        $expectedResponse->setName($name2);
        $expectedResponse->setGcsBucket($gcsBucket);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/scheduleDeleteCertificateAuthorityTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $response = $client->scheduleDeleteCertificateAuthority($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/ScheduleDeleteCertificateAuthority', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/scheduleDeleteCertificateAuthorityTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function scheduleDeleteCertificateAuthorityExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/scheduleDeleteCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->certificateAuthorityName('[PROJECT]', '[LOCATION]', '[CERTIFICATE_AUTHORITY]');
        $response = $client->scheduleDeleteCertificateAuthority($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/scheduleDeleteCertificateAuthorityTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function updateCertificateTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $pemCsr = 'pemCsr-683665829';
        $pemCertificate = 'pemCertificate1234463984';
        $expectedResponse = new Certificate();
        $expectedResponse->setName($name);
        $expectedResponse->setPemCsr($pemCsr);
        $expectedResponse->setPemCertificate($pemCertificate);
        $transport->addResponse($expectedResponse);
        // Mock request
        $certificate = new Certificate();
        $certificateLifetime = new Duration();
        $certificate->setLifetime($certificateLifetime);
        $updateMask = new FieldMask();
        $response = $client->updateCertificate($certificate, $updateMask);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/UpdateCertificate', $actualFuncCall);
        $actualValue = $actualRequestObject->getCertificate();
        $this->assertProtobufEquals($certificate, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateCertificateExceptionTest()
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
        $certificate = new Certificate();
        $certificateLifetime = new Duration();
        $certificate->setLifetime($certificateLifetime);
        $updateMask = new FieldMask();
        try {
            $client->updateCertificate($certificate, $updateMask);
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
    public function updateCertificateAuthorityTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/updateCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $gcsBucket = 'gcsBucket-1720393710';
        $expectedResponse = new CertificateAuthority();
        $expectedResponse->setName($name);
        $expectedResponse->setGcsBucket($gcsBucket);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateCertificateAuthorityTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $certificateAuthority = new CertificateAuthority();
        $certificateAuthorityType = Type::TYPE_UNSPECIFIED;
        $certificateAuthority->setType($certificateAuthorityType);
        $certificateAuthorityTier = Tier::TIER_UNSPECIFIED;
        $certificateAuthority->setTier($certificateAuthorityTier);
        $certificateAuthorityConfig = new CertificateConfig();
        $configSubjectConfig = new SubjectConfig();
        $subjectConfigSubject = new Subject();
        $configSubjectConfig->setSubject($subjectConfigSubject);
        $certificateAuthorityConfig->setSubjectConfig($configSubjectConfig);
        $configReusableConfig = new ReusableConfigWrapper();
        $reusableConfigReusableConfig = 'reusableConfigReusableConfig424335738';
        $configReusableConfig->setReusableConfig($reusableConfigReusableConfig);
        $reusableConfigReusableConfigValues = new ReusableConfigValues();
        $configReusableConfig->setReusableConfigValues($reusableConfigReusableConfigValues);
        $certificateAuthorityConfig->setReusableConfig($configReusableConfig);
        $certificateAuthority->setConfig($certificateAuthorityConfig);
        $certificateAuthorityLifetime = new Duration();
        $certificateAuthority->setLifetime($certificateAuthorityLifetime);
        $certificateAuthorityKeySpec = new KeyVersionSpec();
        $keySpecCloudKmsKeyVersion = 'keySpecCloudKmsKeyVersion170335183';
        $certificateAuthorityKeySpec->setCloudKmsKeyVersion($keySpecCloudKmsKeyVersion);
        $keySpecAlgorithm = SignHashAlgorithm::SIGN_HASH_ALGORITHM_UNSPECIFIED;
        $certificateAuthorityKeySpec->setAlgorithm($keySpecAlgorithm);
        $certificateAuthority->setKeySpec($certificateAuthorityKeySpec);
        $updateMask = new FieldMask();
        $response = $client->updateCertificateAuthority($certificateAuthority, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/UpdateCertificateAuthority', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getCertificateAuthority();
        $this->assertProtobufEquals($certificateAuthority, $actualValue);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateCertificateAuthorityTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function updateCertificateAuthorityExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/updateCertificateAuthorityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $certificateAuthority = new CertificateAuthority();
        $certificateAuthorityType = Type::TYPE_UNSPECIFIED;
        $certificateAuthority->setType($certificateAuthorityType);
        $certificateAuthorityTier = Tier::TIER_UNSPECIFIED;
        $certificateAuthority->setTier($certificateAuthorityTier);
        $certificateAuthorityConfig = new CertificateConfig();
        $configSubjectConfig = new SubjectConfig();
        $subjectConfigSubject = new Subject();
        $configSubjectConfig->setSubject($subjectConfigSubject);
        $certificateAuthorityConfig->setSubjectConfig($configSubjectConfig);
        $configReusableConfig = new ReusableConfigWrapper();
        $reusableConfigReusableConfig = 'reusableConfigReusableConfig424335738';
        $configReusableConfig->setReusableConfig($reusableConfigReusableConfig);
        $reusableConfigReusableConfigValues = new ReusableConfigValues();
        $configReusableConfig->setReusableConfigValues($reusableConfigReusableConfigValues);
        $certificateAuthorityConfig->setReusableConfig($configReusableConfig);
        $certificateAuthority->setConfig($certificateAuthorityConfig);
        $certificateAuthorityLifetime = new Duration();
        $certificateAuthority->setLifetime($certificateAuthorityLifetime);
        $certificateAuthorityKeySpec = new KeyVersionSpec();
        $keySpecCloudKmsKeyVersion = 'keySpecCloudKmsKeyVersion170335183';
        $certificateAuthorityKeySpec->setCloudKmsKeyVersion($keySpecCloudKmsKeyVersion);
        $keySpecAlgorithm = SignHashAlgorithm::SIGN_HASH_ALGORITHM_UNSPECIFIED;
        $certificateAuthorityKeySpec->setAlgorithm($keySpecAlgorithm);
        $certificateAuthority->setKeySpec($certificateAuthorityKeySpec);
        $updateMask = new FieldMask();
        $response = $client->updateCertificateAuthority($certificateAuthority, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateCertificateAuthorityTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function updateCertificateRevocationListTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/updateCertificateRevocationListTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $sequenceNumber = 1309190777;
        $pemCrl = 'pemCrl-683665866';
        $accessUrl = 'accessUrl-1141680108';
        $expectedResponse = new CertificateRevocationList();
        $expectedResponse->setName($name);
        $expectedResponse->setSequenceNumber($sequenceNumber);
        $expectedResponse->setPemCrl($pemCrl);
        $expectedResponse->setAccessUrl($accessUrl);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateCertificateRevocationListTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $certificateRevocationList = new CertificateRevocationList();
        $updateMask = new FieldMask();
        $response = $client->updateCertificateRevocationList($certificateRevocationList, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/UpdateCertificateRevocationList', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getCertificateRevocationList();
        $this->assertProtobufEquals($certificateRevocationList, $actualValue);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateCertificateRevocationListTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function updateCertificateRevocationListExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/updateCertificateRevocationListTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $certificateRevocationList = new CertificateRevocationList();
        $updateMask = new FieldMask();
        $response = $client->updateCertificateRevocationList($certificateRevocationList, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateCertificateRevocationListTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }
}
