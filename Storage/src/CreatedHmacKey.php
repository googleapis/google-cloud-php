<?php
/**
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Storage;

/**
 * Represents a newly created HMAC key. Provides access to the key metadata and
 * secret.
 *
 * Example:
 * ```
 * use Google\Cloud\Storage\StorageClient;
 *
 * $storage = new StorageClient();
 * $response = $storage->createHmacKey($serviceAccountEmail);
 * ```
 */
class CreatedHmacKey
{
    /**
     * @var HmacKey
     */
    private $hmacKey;

    /**
     * @var string
     */
    private $secret;

    /**
     * @param HmacKey $hmacKey The HMAC Key object.
     * @param string $secret The HMAC key secret.
     */
    public function __construct(HmacKey $hmacKey, $secret)
    {
        $this->hmacKey = $hmacKey;
        $this->secret = $secret;
    }

    /**
     * Get the HMAC key object.
     *
     * Example:
     * ```
     * $key = $response->hmacKey();
     * ```
     *
     * @return HmacKey
     */
    public function hmacKey()
    {
        return $this->hmacKey;
    }

    /**
     * Get the HMAC key secret.
     *
     * This value will never be returned from the API after first creation. Make
     * sure to record it for later use immediately upon key creation.
     *
     * Example:
     * ```
     * $secret = $response->secret();
     * ```
     *
     * @return string
     */
    public function secret()
    {
        return $this->secret;
    }
}
