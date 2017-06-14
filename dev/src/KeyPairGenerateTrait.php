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

namespace Google\Cloud\Dev;

trait KeyPairGenerateTrait
{
    private function getKeyPair()
    {
        $privateKey = openssl_pkey_new([
            'digest_alg' => 'sha256',
            'private_key_bits' => 1024,
            'private_key_type' => OPENSSL_KEYTYPE_RSA
        ]);

        $pkey = '';
        openssl_pkey_export($privateKey, $pkey);
        $key = openssl_pkey_get_details($privateKey);
        $pub = $key['key'];

        return [$pkey, $pub];
    }

    private function verifySignature($publicKey, $input, $signature)
    {
        // due to intermittent failures, we'll retry a couple of times to eliminate false failures.
        $res = 0;
        for ($i = 0; $i < 3; $i++) {
            $res = openssl_verify($input, $signature, $publicKey, 'sha256WithRSAEncryption');
            if ($res = 1) {
                break;
            }
        }

        return $res === 1;
    }
}
