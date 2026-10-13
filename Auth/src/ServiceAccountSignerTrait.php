<?php
/*
 * Copyright 2019 Google LLC
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

namespace Google\Auth;

use phpseclib3\Crypt\PublicKeyLoader as PublicKeyLoader3;
use phpseclib3\Crypt\RSA as RSA3;
use phpseclib4\Crypt\PublicKeyLoader as PublicKeyLoader4;
use phpseclib4\Crypt\RSA as RSA4;

/**
 * Sign a string using a Service Account private key.
 */
trait ServiceAccountSignerTrait
{
    /**
     * Sign a string using the service account private key.
     *
     * @param string $stringToSign
     * @param bool $forceOpenssl Whether to use OpenSSL regardless of
     *        whether phpseclib is installed. **Defaults to** `false`.
     * @return string
     */
    public function signBlob($stringToSign, $forceOpenssl = false)
    {
        $privateKey = $this->auth->getSigningKey();

        $signedString = '';
        if (class_exists(RSA4::class) && !$forceOpenssl) {
            $key = PublicKeyLoader4::load($privateKey);
            $rsa = $key->withHash('sha256')->withPadding(RSA4::SIGNATURE_PKCS1);

            $signedString = $rsa->sign($stringToSign);
        } elseif (class_exists(RSA3::class) && !$forceOpenssl) {
            $key = PublicKeyLoader3::load($privateKey);
            $rsa = $key->withHash('sha256')->withPadding(RSA3::SIGNATURE_PKCS1);

            $signedString = $rsa->sign($stringToSign);
        } elseif (extension_loaded('openssl')) {
            openssl_sign($stringToSign, $signedString, $privateKey, 'sha256WithRSAEncryption');
        } else {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException('OpenSSL is not installed.');
        }
        // @codeCoverageIgnoreEnd

        return base64_encode($signedString);
    }
}
