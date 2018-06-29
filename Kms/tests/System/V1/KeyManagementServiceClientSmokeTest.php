<?php

namespace Google\Cloud\Kms\Tests\System\V1;

use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Kms\V1\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\CryptoKey;
use Google\Cloud\Kms\V1\CryptoKey_CryptoKeyPurpose;
use Google\Cloud\Kms\V1\KeyRing;

/**
 * @group kms
 * @group gapic
 */
class KeyManagementServiceClientSmokeTest extends SystemTestCase
{

    /**
     * @test
     */
    public function smokeTest()
    {
        $projectId = getenv('PROJECT_ID');
        if ($projectId === false) {
            $this->fail('Environment variable PROJECT_ID must be set for smoke test');
        }
        $client = new KeyManagementServiceClient();
        $location = 'global';
        $keyRingId = 'system-test-keyring';
        $locationName = $client::locationName($projectId, $location);
        $keyRingName = $client::keyRingName($projectId, $location, $keyRingId);
        try {
            $keyRing = $client->getKeyRing($keyRingName);
        } catch (\Google\ApiCore\ApiException $e) {
            if ($e->getStatus() === 'NOT_FOUND') {
                $keyRing = new KeyRing();
                $keyRing->setName($keyRingName);
                $client->createKeyRing($locationName, $keyRingId, $keyRing);
            }
        }
        $keyId = 'system-test-key';
        $keyName = $client::cryptoKeyName($projectId, $location, $keyRingId, $keyId);

        try {
            $cryptoKey = $client->getCryptoKey($keyName);
        } catch (\Google\ApiCore\ApiException $e) {
            if ($e->getStatus() === 'NOT_FOUND') {
                $cryptoKey = new CryptoKey();
                $cryptoKey->setPurpose(CryptoKey_CryptoKeyPurpose::ENCRYPT_DECRYPT);
                $cryptoKey = $client->createCryptoKey($keyRingName, $keyId, $cryptoKey);
            }
        }
        $secret = 'My secret text';
        $response = $client->encrypt($keyName, $secret);
        $cipherText = $response->getCiphertext();
        
        $response = $client->decrypt($keyName, $cipherText);
        
        $plainText = $response->getPlaintext();

        $this->assertEquals($secret, $plainText);
    }
}
