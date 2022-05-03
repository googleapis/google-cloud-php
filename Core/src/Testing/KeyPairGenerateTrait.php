<?php
/**
 * Copyright 2017 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Core\Testing;

use Google\Cloud\Storage\EncryptionTrait;
use phpseclib3\Crypt\RSA;

/**
 * Trait KeyPairGenerateTrait implements key pair generation functions used for testing
 *
 * @experimental
 * @internal
 */
trait KeyPairGenerateTrait
{
    use EncryptionTrait;

    private function getKeyPair()
    {
        $key = (RSA::createKey())
            ->withPadding(RSA::SIGNATURE_PKCS1)
            ->withHash('sha256');

        return [$key->toString('PKCS1'), $key->getPublicKey()];
    }

    private function verifySignature($privateKey, $input, $signature)
    {
        $verify = $this->signString($privateKey, $input);

        return urlencode(base64_encode($verify)) === $signature;
    }
}
