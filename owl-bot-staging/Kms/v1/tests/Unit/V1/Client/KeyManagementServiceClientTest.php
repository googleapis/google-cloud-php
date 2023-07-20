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

namespace Google\Cloud\Kms\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\Kms\V1\AsymmetricDecryptRequest;
use Google\Cloud\Kms\V1\AsymmetricDecryptResponse;
use Google\Cloud\Kms\V1\AsymmetricSignRequest;
use Google\Cloud\Kms\V1\AsymmetricSignResponse;
use Google\Cloud\Kms\V1\Client\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\CreateCryptoKeyRequest;
use Google\Cloud\Kms\V1\CreateCryptoKeyVersionRequest;
use Google\Cloud\Kms\V1\CreateImportJobRequest;
use Google\Cloud\Kms\V1\CreateKeyRingRequest;
use Google\Cloud\Kms\V1\CryptoKey;
use Google\Cloud\Kms\V1\CryptoKeyVersion;
use Google\Cloud\Kms\V1\CryptoKeyVersion\CryptoKeyVersionAlgorithm;
use Google\Cloud\Kms\V1\DecryptRequest;
use Google\Cloud\Kms\V1\DecryptResponse;
use Google\Cloud\Kms\V1\DestroyCryptoKeyVersionRequest;
use Google\Cloud\Kms\V1\Digest;
use Google\Cloud\Kms\V1\EncryptRequest;
use Google\Cloud\Kms\V1\EncryptResponse;
use Google\Cloud\Kms\V1\GenerateRandomBytesRequest;
use Google\Cloud\Kms\V1\GenerateRandomBytesResponse;
use Google\Cloud\Kms\V1\GetCryptoKeyRequest;
use Google\Cloud\Kms\V1\GetCryptoKeyVersionRequest;
use Google\Cloud\Kms\V1\GetImportJobRequest;
use Google\Cloud\Kms\V1\GetKeyRingRequest;
use Google\Cloud\Kms\V1\GetPublicKeyRequest;
use Google\Cloud\Kms\V1\ImportCryptoKeyVersionRequest;
use Google\Cloud\Kms\V1\ImportJob;
use Google\Cloud\Kms\V1\ImportJob\ImportMethod;
use Google\Cloud\Kms\V1\KeyRing;
use Google\Cloud\Kms\V1\ListCryptoKeyVersionsRequest;
use Google\Cloud\Kms\V1\ListCryptoKeyVersionsResponse;
use Google\Cloud\Kms\V1\ListCryptoKeysRequest;
use Google\Cloud\Kms\V1\ListCryptoKeysResponse;
use Google\Cloud\Kms\V1\ListImportJobsRequest;
use Google\Cloud\Kms\V1\ListImportJobsResponse;
use Google\Cloud\Kms\V1\ListKeyRingsRequest;
use Google\Cloud\Kms\V1\ListKeyRingsResponse;
use Google\Cloud\Kms\V1\MacSignRequest;
use Google\Cloud\Kms\V1\MacSignResponse;
use Google\Cloud\Kms\V1\MacVerifyRequest;
use Google\Cloud\Kms\V1\MacVerifyResponse;
use Google\Cloud\Kms\V1\ProtectionLevel;
use Google\Cloud\Kms\V1\PublicKey;
use Google\Cloud\Kms\V1\RawDecryptRequest;
use Google\Cloud\Kms\V1\RawDecryptResponse;
use Google\Cloud\Kms\V1\RawEncryptRequest;
use Google\Cloud\Kms\V1\RawEncryptResponse;
use Google\Cloud\Kms\V1\RestoreCryptoKeyVersionRequest;
use Google\Cloud\Kms\V1\UpdateCryptoKeyPrimaryVersionRequest;
use Google\Cloud\Kms\V1\UpdateCryptoKeyRequest;
use Google\Cloud\Kms\V1\UpdateCryptoKeyVersionRequest;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use stdClass;

/**
 * @group kms
 *
 * @group gapic
 */
class KeyManagementServiceClientTest extends GeneratedTest
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

    /** @return KeyManagementServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new KeyManagementServiceClient($options);
    }

    /** @test */
    public function asymmetricDecryptTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $plaintext = '-9';
        $verifiedCiphertextCrc32c = true;
        $expectedResponse = new AsymmetricDecryptResponse();
        $expectedResponse->setPlaintext($plaintext);
        $expectedResponse->setVerifiedCiphertextCrc32c($verifiedCiphertextCrc32c);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $ciphertext = '-72';
        $request = (new AsymmetricDecryptRequest())
            ->setName($formattedName)
            ->setCiphertext($ciphertext);
        $response = $gapicClient->asymmetricDecrypt($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/AsymmetricDecrypt', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getCiphertext();
        $this->assertProtobufEquals($ciphertext, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function asymmetricDecryptExceptionTest()
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
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $ciphertext = '-72';
        $request = (new AsymmetricDecryptRequest())
            ->setName($formattedName)
            ->setCiphertext($ciphertext);
        try {
            $gapicClient->asymmetricDecrypt($request);
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
    public function asymmetricSignTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $signature = '-72';
        $verifiedDigestCrc32c = true;
        $name2 = 'name2-1052831874';
        $verifiedDataCrc32c = true;
        $expectedResponse = new AsymmetricSignResponse();
        $expectedResponse->setSignature($signature);
        $expectedResponse->setVerifiedDigestCrc32c($verifiedDigestCrc32c);
        $expectedResponse->setName($name2);
        $expectedResponse->setVerifiedDataCrc32c($verifiedDataCrc32c);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $digest = new Digest();
        $request = (new AsymmetricSignRequest())
            ->setName($formattedName)
            ->setDigest($digest);
        $response = $gapicClient->asymmetricSign($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/AsymmetricSign', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getDigest();
        $this->assertProtobufEquals($digest, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function asymmetricSignExceptionTest()
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
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $digest = new Digest();
        $request = (new AsymmetricSignRequest())
            ->setName($formattedName)
            ->setDigest($digest);
        try {
            $gapicClient->asymmetricSign($request);
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
    public function createCryptoKeyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $importOnly = true;
        $cryptoKeyBackend = 'cryptoKeyBackend-1526615498';
        $expectedResponse = new CryptoKey();
        $expectedResponse->setName($name);
        $expectedResponse->setImportOnly($importOnly);
        $expectedResponse->setCryptoKeyBackend($cryptoKeyBackend);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
        $cryptoKeyId = 'cryptoKeyId-2123094983';
        $cryptoKey = new CryptoKey();
        $request = (new CreateCryptoKeyRequest())
            ->setParent($formattedParent)
            ->setCryptoKeyId($cryptoKeyId)
            ->setCryptoKey($cryptoKey);
        $response = $gapicClient->createCryptoKey($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/CreateCryptoKey', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCryptoKeyId();
        $this->assertProtobufEquals($cryptoKeyId, $actualValue);
        $actualValue = $actualRequestObject->getCryptoKey();
        $this->assertProtobufEquals($cryptoKey, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCryptoKeyExceptionTest()
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
        $formattedParent = $gapicClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
        $cryptoKeyId = 'cryptoKeyId-2123094983';
        $cryptoKey = new CryptoKey();
        $request = (new CreateCryptoKeyRequest())
            ->setParent($formattedParent)
            ->setCryptoKeyId($cryptoKeyId)
            ->setCryptoKey($cryptoKey);
        try {
            $gapicClient->createCryptoKey($request);
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
    public function createCryptoKeyVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $importJob = 'importJob2125587491';
        $importFailureReason = 'importFailureReason-494073229';
        $generationFailureReason = 'generationFailureReason1749803168';
        $externalDestructionFailureReason = 'externalDestructionFailureReason-2122384710';
        $reimportEligible = true;
        $expectedResponse = new CryptoKeyVersion();
        $expectedResponse->setName($name);
        $expectedResponse->setImportJob($importJob);
        $expectedResponse->setImportFailureReason($importFailureReason);
        $expectedResponse->setGenerationFailureReason($generationFailureReason);
        $expectedResponse->setExternalDestructionFailureReason($externalDestructionFailureReason);
        $expectedResponse->setReimportEligible($reimportEligible);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $cryptoKeyVersion = new CryptoKeyVersion();
        $request = (new CreateCryptoKeyVersionRequest())
            ->setParent($formattedParent)
            ->setCryptoKeyVersion($cryptoKeyVersion);
        $response = $gapicClient->createCryptoKeyVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/CreateCryptoKeyVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCryptoKeyVersion();
        $this->assertProtobufEquals($cryptoKeyVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCryptoKeyVersionExceptionTest()
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
        $formattedParent = $gapicClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $cryptoKeyVersion = new CryptoKeyVersion();
        $request = (new CreateCryptoKeyVersionRequest())
            ->setParent($formattedParent)
            ->setCryptoKeyVersion($cryptoKeyVersion);
        try {
            $gapicClient->createCryptoKeyVersion($request);
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
    public function createImportJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new ImportJob();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
        $importJobId = 'importJobId-1620773193';
        $importJob = new ImportJob();
        $importJobImportMethod = ImportMethod::IMPORT_METHOD_UNSPECIFIED;
        $importJob->setImportMethod($importJobImportMethod);
        $importJobProtectionLevel = ProtectionLevel::PROTECTION_LEVEL_UNSPECIFIED;
        $importJob->setProtectionLevel($importJobProtectionLevel);
        $request = (new CreateImportJobRequest())
            ->setParent($formattedParent)
            ->setImportJobId($importJobId)
            ->setImportJob($importJob);
        $response = $gapicClient->createImportJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/CreateImportJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getImportJobId();
        $this->assertProtobufEquals($importJobId, $actualValue);
        $actualValue = $actualRequestObject->getImportJob();
        $this->assertProtobufEquals($importJob, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createImportJobExceptionTest()
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
        $formattedParent = $gapicClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
        $importJobId = 'importJobId-1620773193';
        $importJob = new ImportJob();
        $importJobImportMethod = ImportMethod::IMPORT_METHOD_UNSPECIFIED;
        $importJob->setImportMethod($importJobImportMethod);
        $importJobProtectionLevel = ProtectionLevel::PROTECTION_LEVEL_UNSPECIFIED;
        $importJob->setProtectionLevel($importJobProtectionLevel);
        $request = (new CreateImportJobRequest())
            ->setParent($formattedParent)
            ->setImportJobId($importJobId)
            ->setImportJob($importJob);
        try {
            $gapicClient->createImportJob($request);
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
    public function createKeyRingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new KeyRing();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $keyRingId = 'keyRingId-2056646742';
        $keyRing = new KeyRing();
        $request = (new CreateKeyRingRequest())
            ->setParent($formattedParent)
            ->setKeyRingId($keyRingId)
            ->setKeyRing($keyRing);
        $response = $gapicClient->createKeyRing($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/CreateKeyRing', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getKeyRingId();
        $this->assertProtobufEquals($keyRingId, $actualValue);
        $actualValue = $actualRequestObject->getKeyRing();
        $this->assertProtobufEquals($keyRing, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createKeyRingExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $keyRingId = 'keyRingId-2056646742';
        $keyRing = new KeyRing();
        $request = (new CreateKeyRingRequest())
            ->setParent($formattedParent)
            ->setKeyRingId($keyRingId)
            ->setKeyRing($keyRing);
        try {
            $gapicClient->createKeyRing($request);
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
    public function decryptTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $plaintext = '-9';
        $usedPrimary = true;
        $expectedResponse = new DecryptResponse();
        $expectedResponse->setPlaintext($plaintext);
        $expectedResponse->setUsedPrimary($usedPrimary);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $ciphertext = '-72';
        $request = (new DecryptRequest())
            ->setName($formattedName)
            ->setCiphertext($ciphertext);
        $response = $gapicClient->decrypt($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/Decrypt', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getCiphertext();
        $this->assertProtobufEquals($ciphertext, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function decryptExceptionTest()
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
        $formattedName = $gapicClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $ciphertext = '-72';
        $request = (new DecryptRequest())
            ->setName($formattedName)
            ->setCiphertext($ciphertext);
        try {
            $gapicClient->decrypt($request);
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
    public function destroyCryptoKeyVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $importJob = 'importJob2125587491';
        $importFailureReason = 'importFailureReason-494073229';
        $generationFailureReason = 'generationFailureReason1749803168';
        $externalDestructionFailureReason = 'externalDestructionFailureReason-2122384710';
        $reimportEligible = true;
        $expectedResponse = new CryptoKeyVersion();
        $expectedResponse->setName($name2);
        $expectedResponse->setImportJob($importJob);
        $expectedResponse->setImportFailureReason($importFailureReason);
        $expectedResponse->setGenerationFailureReason($generationFailureReason);
        $expectedResponse->setExternalDestructionFailureReason($externalDestructionFailureReason);
        $expectedResponse->setReimportEligible($reimportEligible);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $request = (new DestroyCryptoKeyVersionRequest())
            ->setName($formattedName);
        $response = $gapicClient->destroyCryptoKeyVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/DestroyCryptoKeyVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function destroyCryptoKeyVersionExceptionTest()
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
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $request = (new DestroyCryptoKeyVersionRequest())
            ->setName($formattedName);
        try {
            $gapicClient->destroyCryptoKeyVersion($request);
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
    public function encryptTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $ciphertext = '-72';
        $verifiedPlaintextCrc32c = false;
        $verifiedAdditionalAuthenticatedDataCrc32c = true;
        $expectedResponse = new EncryptResponse();
        $expectedResponse->setName($name2);
        $expectedResponse->setCiphertext($ciphertext);
        $expectedResponse->setVerifiedPlaintextCrc32c($verifiedPlaintextCrc32c);
        $expectedResponse->setVerifiedAdditionalAuthenticatedDataCrc32c($verifiedAdditionalAuthenticatedDataCrc32c);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $plaintext = '-9';
        $request = (new EncryptRequest())
            ->setName($name)
            ->setPlaintext($plaintext);
        $response = $gapicClient->encrypt($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/Encrypt', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getPlaintext();
        $this->assertProtobufEquals($plaintext, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function encryptExceptionTest()
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
        $name = 'name3373707';
        $plaintext = '-9';
        $request = (new EncryptRequest())
            ->setName($name)
            ->setPlaintext($plaintext);
        try {
            $gapicClient->encrypt($request);
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
    public function generateRandomBytesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $data = '-86';
        $expectedResponse = new GenerateRandomBytesResponse();
        $expectedResponse->setData($data);
        $transport->addResponse($expectedResponse);
        $request = new GenerateRandomBytesRequest();
        $response = $gapicClient->generateRandomBytes($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/GenerateRandomBytes', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function generateRandomBytesExceptionTest()
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
        $request = new GenerateRandomBytesRequest();
        try {
            $gapicClient->generateRandomBytes($request);
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
    public function getCryptoKeyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $importOnly = true;
        $cryptoKeyBackend = 'cryptoKeyBackend-1526615498';
        $expectedResponse = new CryptoKey();
        $expectedResponse->setName($name2);
        $expectedResponse->setImportOnly($importOnly);
        $expectedResponse->setCryptoKeyBackend($cryptoKeyBackend);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $request = (new GetCryptoKeyRequest())
            ->setName($formattedName);
        $response = $gapicClient->getCryptoKey($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/GetCryptoKey', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCryptoKeyExceptionTest()
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
        $formattedName = $gapicClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $request = (new GetCryptoKeyRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getCryptoKey($request);
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
    public function getCryptoKeyVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $importJob = 'importJob2125587491';
        $importFailureReason = 'importFailureReason-494073229';
        $generationFailureReason = 'generationFailureReason1749803168';
        $externalDestructionFailureReason = 'externalDestructionFailureReason-2122384710';
        $reimportEligible = true;
        $expectedResponse = new CryptoKeyVersion();
        $expectedResponse->setName($name2);
        $expectedResponse->setImportJob($importJob);
        $expectedResponse->setImportFailureReason($importFailureReason);
        $expectedResponse->setGenerationFailureReason($generationFailureReason);
        $expectedResponse->setExternalDestructionFailureReason($externalDestructionFailureReason);
        $expectedResponse->setReimportEligible($reimportEligible);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $request = (new GetCryptoKeyVersionRequest())
            ->setName($formattedName);
        $response = $gapicClient->getCryptoKeyVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/GetCryptoKeyVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCryptoKeyVersionExceptionTest()
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
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $request = (new GetCryptoKeyVersionRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getCryptoKeyVersion($request);
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
    public function getImportJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new ImportJob();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->importJobName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[IMPORT_JOB]');
        $request = (new GetImportJobRequest())
            ->setName($formattedName);
        $response = $gapicClient->getImportJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/GetImportJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getImportJobExceptionTest()
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
        $formattedName = $gapicClient->importJobName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[IMPORT_JOB]');
        $request = (new GetImportJobRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getImportJob($request);
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
    public function getKeyRingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new KeyRing();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
        $request = (new GetKeyRingRequest())
            ->setName($formattedName);
        $response = $gapicClient->getKeyRing($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/GetKeyRing', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getKeyRingExceptionTest()
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
        $formattedName = $gapicClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
        $request = (new GetKeyRingRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getKeyRing($request);
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
    public function getPublicKeyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $pem = 'pem110872';
        $name2 = 'name2-1052831874';
        $expectedResponse = new PublicKey();
        $expectedResponse->setPem($pem);
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $request = (new GetPublicKeyRequest())
            ->setName($formattedName);
        $response = $gapicClient->getPublicKey($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/GetPublicKey', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getPublicKeyExceptionTest()
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
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $request = (new GetPublicKeyRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getPublicKey($request);
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
    public function importCryptoKeyVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $importJob2 = 'importJob2-1714851050';
        $importFailureReason = 'importFailureReason-494073229';
        $generationFailureReason = 'generationFailureReason1749803168';
        $externalDestructionFailureReason = 'externalDestructionFailureReason-2122384710';
        $reimportEligible = true;
        $expectedResponse = new CryptoKeyVersion();
        $expectedResponse->setName($name);
        $expectedResponse->setImportJob($importJob2);
        $expectedResponse->setImportFailureReason($importFailureReason);
        $expectedResponse->setGenerationFailureReason($generationFailureReason);
        $expectedResponse->setExternalDestructionFailureReason($externalDestructionFailureReason);
        $expectedResponse->setReimportEligible($reimportEligible);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $algorithm = CryptoKeyVersionAlgorithm::CRYPTO_KEY_VERSION_ALGORITHM_UNSPECIFIED;
        $importJob = 'importJob2125587491';
        $request = (new ImportCryptoKeyVersionRequest())
            ->setParent($formattedParent)
            ->setAlgorithm($algorithm)
            ->setImportJob($importJob);
        $response = $gapicClient->importCryptoKeyVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/ImportCryptoKeyVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAlgorithm();
        $this->assertProtobufEquals($algorithm, $actualValue);
        $actualValue = $actualRequestObject->getImportJob();
        $this->assertProtobufEquals($importJob, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function importCryptoKeyVersionExceptionTest()
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
        $formattedParent = $gapicClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $algorithm = CryptoKeyVersionAlgorithm::CRYPTO_KEY_VERSION_ALGORITHM_UNSPECIFIED;
        $importJob = 'importJob2125587491';
        $request = (new ImportCryptoKeyVersionRequest())
            ->setParent($formattedParent)
            ->setAlgorithm($algorithm)
            ->setImportJob($importJob);
        try {
            $gapicClient->importCryptoKeyVersion($request);
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
    public function listCryptoKeyVersionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $cryptoKeyVersionsElement = new CryptoKeyVersion();
        $cryptoKeyVersions = [
            $cryptoKeyVersionsElement,
        ];
        $expectedResponse = new ListCryptoKeyVersionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setCryptoKeyVersions($cryptoKeyVersions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $request = (new ListCryptoKeyVersionsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listCryptoKeyVersions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCryptoKeyVersions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/ListCryptoKeyVersions', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCryptoKeyVersionsExceptionTest()
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
        $formattedParent = $gapicClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $request = (new ListCryptoKeyVersionsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listCryptoKeyVersions($request);
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
    public function listCryptoKeysTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $cryptoKeysElement = new CryptoKey();
        $cryptoKeys = [
            $cryptoKeysElement,
        ];
        $expectedResponse = new ListCryptoKeysResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setCryptoKeys($cryptoKeys);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
        $request = (new ListCryptoKeysRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listCryptoKeys($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCryptoKeys()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/ListCryptoKeys', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCryptoKeysExceptionTest()
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
        $formattedParent = $gapicClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
        $request = (new ListCryptoKeysRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listCryptoKeys($request);
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
    public function listImportJobsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $importJobsElement = new ImportJob();
        $importJobs = [
            $importJobsElement,
        ];
        $expectedResponse = new ListImportJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setImportJobs($importJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
        $request = (new ListImportJobsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listImportJobs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getImportJobs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/ListImportJobs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listImportJobsExceptionTest()
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
        $formattedParent = $gapicClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
        $request = (new ListImportJobsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listImportJobs($request);
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
    public function listKeyRingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $keyRingsElement = new KeyRing();
        $keyRings = [
            $keyRingsElement,
        ];
        $expectedResponse = new ListKeyRingsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setKeyRings($keyRings);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListKeyRingsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listKeyRings($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getKeyRings()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/ListKeyRings', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listKeyRingsExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListKeyRingsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listKeyRings($request);
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
    public function macSignTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $mac = '79';
        $verifiedDataCrc32c = true;
        $expectedResponse = new MacSignResponse();
        $expectedResponse->setName($name2);
        $expectedResponse->setMac($mac);
        $expectedResponse->setVerifiedDataCrc32c($verifiedDataCrc32c);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $data = '-86';
        $request = (new MacSignRequest())
            ->setName($formattedName)
            ->setData($data);
        $response = $gapicClient->macSign($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/MacSign', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getData();
        $this->assertProtobufEquals($data, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function macSignExceptionTest()
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
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $data = '-86';
        $request = (new MacSignRequest())
            ->setName($formattedName)
            ->setData($data);
        try {
            $gapicClient->macSign($request);
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
    public function macVerifyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $success = false;
        $verifiedDataCrc32c = true;
        $verifiedMacCrc32c = false;
        $verifiedSuccessIntegrity = true;
        $expectedResponse = new MacVerifyResponse();
        $expectedResponse->setName($name2);
        $expectedResponse->setSuccess($success);
        $expectedResponse->setVerifiedDataCrc32c($verifiedDataCrc32c);
        $expectedResponse->setVerifiedMacCrc32c($verifiedMacCrc32c);
        $expectedResponse->setVerifiedSuccessIntegrity($verifiedSuccessIntegrity);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $data = '-86';
        $mac = '79';
        $request = (new MacVerifyRequest())
            ->setName($formattedName)
            ->setData($data)
            ->setMac($mac);
        $response = $gapicClient->macVerify($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/MacVerify', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getData();
        $this->assertProtobufEquals($data, $actualValue);
        $actualValue = $actualRequestObject->getMac();
        $this->assertProtobufEquals($mac, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function macVerifyExceptionTest()
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
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $data = '-86';
        $mac = '79';
        $request = (new MacVerifyRequest())
            ->setName($formattedName)
            ->setData($data)
            ->setMac($mac);
        try {
            $gapicClient->macVerify($request);
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
    public function rawDecryptTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $plaintext = '-9';
        $verifiedCiphertextCrc32c = true;
        $verifiedAdditionalAuthenticatedDataCrc32c = true;
        $verifiedInitializationVectorCrc32c = true;
        $expectedResponse = new RawDecryptResponse();
        $expectedResponse->setPlaintext($plaintext);
        $expectedResponse->setVerifiedCiphertextCrc32c($verifiedCiphertextCrc32c);
        $expectedResponse->setVerifiedAdditionalAuthenticatedDataCrc32c($verifiedAdditionalAuthenticatedDataCrc32c);
        $expectedResponse->setVerifiedInitializationVectorCrc32c($verifiedInitializationVectorCrc32c);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $ciphertext = '-72';
        $initializationVector = '-62';
        $request = (new RawDecryptRequest())
            ->setName($name)
            ->setCiphertext($ciphertext)
            ->setInitializationVector($initializationVector);
        $response = $gapicClient->rawDecrypt($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/RawDecrypt', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getCiphertext();
        $this->assertProtobufEquals($ciphertext, $actualValue);
        $actualValue = $actualRequestObject->getInitializationVector();
        $this->assertProtobufEquals($initializationVector, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function rawDecryptExceptionTest()
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
        $name = 'name3373707';
        $ciphertext = '-72';
        $initializationVector = '-62';
        $request = (new RawDecryptRequest())
            ->setName($name)
            ->setCiphertext($ciphertext)
            ->setInitializationVector($initializationVector);
        try {
            $gapicClient->rawDecrypt($request);
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
    public function rawEncryptTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $ciphertext = '-72';
        $initializationVector2 = '-11';
        $tagLength = 172791595;
        $verifiedPlaintextCrc32c = false;
        $verifiedAdditionalAuthenticatedDataCrc32c = true;
        $verifiedInitializationVectorCrc32c = true;
        $name2 = 'name2-1052831874';
        $expectedResponse = new RawEncryptResponse();
        $expectedResponse->setCiphertext($ciphertext);
        $expectedResponse->setInitializationVector($initializationVector2);
        $expectedResponse->setTagLength($tagLength);
        $expectedResponse->setVerifiedPlaintextCrc32c($verifiedPlaintextCrc32c);
        $expectedResponse->setVerifiedAdditionalAuthenticatedDataCrc32c($verifiedAdditionalAuthenticatedDataCrc32c);
        $expectedResponse->setVerifiedInitializationVectorCrc32c($verifiedInitializationVectorCrc32c);
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $plaintext = '-9';
        $request = (new RawEncryptRequest())
            ->setName($name)
            ->setPlaintext($plaintext);
        $response = $gapicClient->rawEncrypt($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/RawEncrypt', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getPlaintext();
        $this->assertProtobufEquals($plaintext, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function rawEncryptExceptionTest()
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
        $name = 'name3373707';
        $plaintext = '-9';
        $request = (new RawEncryptRequest())
            ->setName($name)
            ->setPlaintext($plaintext);
        try {
            $gapicClient->rawEncrypt($request);
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
    public function restoreCryptoKeyVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $importJob = 'importJob2125587491';
        $importFailureReason = 'importFailureReason-494073229';
        $generationFailureReason = 'generationFailureReason1749803168';
        $externalDestructionFailureReason = 'externalDestructionFailureReason-2122384710';
        $reimportEligible = true;
        $expectedResponse = new CryptoKeyVersion();
        $expectedResponse->setName($name2);
        $expectedResponse->setImportJob($importJob);
        $expectedResponse->setImportFailureReason($importFailureReason);
        $expectedResponse->setGenerationFailureReason($generationFailureReason);
        $expectedResponse->setExternalDestructionFailureReason($externalDestructionFailureReason);
        $expectedResponse->setReimportEligible($reimportEligible);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $request = (new RestoreCryptoKeyVersionRequest())
            ->setName($formattedName);
        $response = $gapicClient->restoreCryptoKeyVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/RestoreCryptoKeyVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function restoreCryptoKeyVersionExceptionTest()
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
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $request = (new RestoreCryptoKeyVersionRequest())
            ->setName($formattedName);
        try {
            $gapicClient->restoreCryptoKeyVersion($request);
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
    public function updateCryptoKeyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $importOnly = true;
        $cryptoKeyBackend = 'cryptoKeyBackend-1526615498';
        $expectedResponse = new CryptoKey();
        $expectedResponse->setName($name);
        $expectedResponse->setImportOnly($importOnly);
        $expectedResponse->setCryptoKeyBackend($cryptoKeyBackend);
        $transport->addResponse($expectedResponse);
        // Mock request
        $cryptoKey = new CryptoKey();
        $updateMask = new FieldMask();
        $request = (new UpdateCryptoKeyRequest())
            ->setCryptoKey($cryptoKey)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateCryptoKey($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/UpdateCryptoKey', $actualFuncCall);
        $actualValue = $actualRequestObject->getCryptoKey();
        $this->assertProtobufEquals($cryptoKey, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCryptoKeyExceptionTest()
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
        $cryptoKey = new CryptoKey();
        $updateMask = new FieldMask();
        $request = (new UpdateCryptoKeyRequest())
            ->setCryptoKey($cryptoKey)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateCryptoKey($request);
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
    public function updateCryptoKeyPrimaryVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $importOnly = true;
        $cryptoKeyBackend = 'cryptoKeyBackend-1526615498';
        $expectedResponse = new CryptoKey();
        $expectedResponse->setName($name2);
        $expectedResponse->setImportOnly($importOnly);
        $expectedResponse->setCryptoKeyBackend($cryptoKeyBackend);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $cryptoKeyVersionId = 'cryptoKeyVersionId729489152';
        $request = (new UpdateCryptoKeyPrimaryVersionRequest())
            ->setName($formattedName)
            ->setCryptoKeyVersionId($cryptoKeyVersionId);
        $response = $gapicClient->updateCryptoKeyPrimaryVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/UpdateCryptoKeyPrimaryVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getCryptoKeyVersionId();
        $this->assertProtobufEquals($cryptoKeyVersionId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCryptoKeyPrimaryVersionExceptionTest()
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
        $formattedName = $gapicClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $cryptoKeyVersionId = 'cryptoKeyVersionId729489152';
        $request = (new UpdateCryptoKeyPrimaryVersionRequest())
            ->setName($formattedName)
            ->setCryptoKeyVersionId($cryptoKeyVersionId);
        try {
            $gapicClient->updateCryptoKeyPrimaryVersion($request);
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
    public function updateCryptoKeyVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $importJob = 'importJob2125587491';
        $importFailureReason = 'importFailureReason-494073229';
        $generationFailureReason = 'generationFailureReason1749803168';
        $externalDestructionFailureReason = 'externalDestructionFailureReason-2122384710';
        $reimportEligible = true;
        $expectedResponse = new CryptoKeyVersion();
        $expectedResponse->setName($name);
        $expectedResponse->setImportJob($importJob);
        $expectedResponse->setImportFailureReason($importFailureReason);
        $expectedResponse->setGenerationFailureReason($generationFailureReason);
        $expectedResponse->setExternalDestructionFailureReason($externalDestructionFailureReason);
        $expectedResponse->setReimportEligible($reimportEligible);
        $transport->addResponse($expectedResponse);
        // Mock request
        $cryptoKeyVersion = new CryptoKeyVersion();
        $updateMask = new FieldMask();
        $request = (new UpdateCryptoKeyVersionRequest())
            ->setCryptoKeyVersion($cryptoKeyVersion)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateCryptoKeyVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/UpdateCryptoKeyVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getCryptoKeyVersion();
        $this->assertProtobufEquals($cryptoKeyVersion, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCryptoKeyVersionExceptionTest()
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
        $cryptoKeyVersion = new CryptoKeyVersion();
        $updateMask = new FieldMask();
        $request = (new UpdateCryptoKeyVersionRequest())
            ->setCryptoKeyVersion($cryptoKeyVersion)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateCryptoKeyVersion($request);
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
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
        $locations = [
            $locationsElement,
        ];
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
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
    public function getIamPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $version = 351608024;
        $etag = '21';
        $expectedResponse = new Policy();
        $expectedResponse->setVersion($version);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $request = (new GetIamPolicyRequest())
            ->setResource($resource);
        $response = $gapicClient->getIamPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.iam.v1.IAMPolicy/GetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getIamPolicyExceptionTest()
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
        $resource = 'resource-341064690';
        $request = (new GetIamPolicyRequest())
            ->setResource($resource);
        try {
            $gapicClient->getIamPolicy($request);
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
    public function setIamPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $version = 351608024;
        $etag = '21';
        $expectedResponse = new Policy();
        $expectedResponse->setVersion($version);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $policy = new Policy();
        $request = (new SetIamPolicyRequest())
            ->setResource($resource)
            ->setPolicy($policy);
        $response = $gapicClient->setIamPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.iam.v1.IAMPolicy/SetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getPolicy();
        $this->assertProtobufEquals($policy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setIamPolicyExceptionTest()
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
        $resource = 'resource-341064690';
        $policy = new Policy();
        $request = (new SetIamPolicyRequest())
            ->setResource($resource)
            ->setPolicy($policy);
        try {
            $gapicClient->setIamPolicy($request);
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
    public function testIamPermissionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new TestIamPermissionsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $permissions = [];
        $request = (new TestIamPermissionsRequest())
            ->setResource($resource)
            ->setPermissions($permissions);
        $response = $gapicClient->testIamPermissions($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.iam.v1.IAMPolicy/TestIamPermissions', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getPermissions();
        $this->assertProtobufEquals($permissions, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function testIamPermissionsExceptionTest()
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
        $resource = 'resource-341064690';
        $permissions = [];
        $request = (new TestIamPermissionsRequest())
            ->setResource($resource)
            ->setPermissions($permissions);
        try {
            $gapicClient->testIamPermissions($request);
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
    public function asymmetricDecryptAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $plaintext = '-9';
        $verifiedCiphertextCrc32c = true;
        $expectedResponse = new AsymmetricDecryptResponse();
        $expectedResponse->setPlaintext($plaintext);
        $expectedResponse->setVerifiedCiphertextCrc32c($verifiedCiphertextCrc32c);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
        $ciphertext = '-72';
        $request = (new AsymmetricDecryptRequest())
            ->setName($formattedName)
            ->setCiphertext($ciphertext);
        $response = $gapicClient->asymmetricDecryptAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.v1.KeyManagementService/AsymmetricDecrypt', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getCiphertext();
        $this->assertProtobufEquals($ciphertext, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
